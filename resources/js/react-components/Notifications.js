import React, { Fragment, Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js'

window.Pusher = Pusher;

export default class Notifications extends Component {
    constructor(props) {
        super(props);
        this.state = {
            notifications: [],
            NOTIFICATION_TYPES: {
                journeyLiked: 'App\\Notifications\\JourneyLiked',
                journeyCommented: 'App\\Notifications\\JourneyCommented',
            }
        };
        this.markAllAsRead = this.markAllAsRead.bind(this);
    }

    componentDidMount() {
        axios
            .get('/unreadNotifications')
            .then(res => {
                this.setState({
                    ...this.state,
                    notifications: res.data
                });
            })
            .then(() => {
                const echo = new Echo({
                    broadcaster: 'pusher',
                    key: process.env.MIX_PUSHER_APP_KEY,
                    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                    forceTLS: true
                });
        
                if(uId) {
                    echo.private(`App.Models.User.${uId}`)
                        .notification(notification => {
                            this.setState({
                                ...this.state,
                                notifications: [notification, ...this.state.notifications]
                            })
                        });
                }
            })
            .catch(err => console.error(err));
    }

    markAllAsRead() {
        axios
            .put('/notifications/readAll')
            .then(() => {
                this.setState({
                    ...this.state,
                    notifications: []
                })
            })
            .catch(err => console.error(err));
    }

    render() {
        const { notifications, NOTIFICATION_TYPES } = this.state;
        const { uId } = this.props;
        return (
            <Fragment>
                <button className="notifications-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img className="notifications-bell" src="/images/bell-2-48.png"></img>
                    <span className="notifications-count">{ `(${notifications.length})` }</span>
                </button>
                <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    { notifications.length == 0 && <a className="dropdown-item" href="#">No new notifications</a> }
                    { notifications.length > 0 && 
                        <Fragment>
                            <button onClick={() => this.markAllAsRead()} className="btn btn-danger" type="button">Mark all as read</button>
                            <Fragment>
                                {
                                    notifications.map(e => 
                                            <div key={e.id}>
                                                { e.type == NOTIFICATION_TYPES.journeyLiked && 
                                                    <a className="dropdown-item" href={`/users/${uId}/journeys/${e.data.journey_id}`}>{ e.data.sender_user_name } liked your journey</a>
                                                }

                                                { e.type == NOTIFICATION_TYPES.journeyCommented && 
                                                    <a className="dropdown-item" href={`/users/${uId}/journeys/${e.data.journey_id}`}>{ e.data.sender_user_name } left a comment on your journey</a>
                                                }
                                            </div>          
                                    )
                                }
                            </Fragment>
                        </Fragment>
                    } 
                </div> 
            </Fragment>
        )
    }
}


const ntfs = document.querySelector('.notifications');
const uId = document.querySelector("meta[name='user-id']").getAttribute('content');
ReactDOM.render(<Notifications uId={uId}/>, ntfs);