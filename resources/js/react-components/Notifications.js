import React, { useState, useEffect, Fragment } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default function Notifications() {
    const [notifications, changeNotifications] = useState([]);

    const NOTIFICATION_TYPES = {
        journeyLiked: 'App\\Notifications\\JourneyLiked'
    };

    useEffect(() => {
        axios
            .get('/notifications')
            .then(res => {
                console.log(res);
                changeNotifications(res.data);
            })
            .catch(err => console.error(err));
    }, [])

    return (
        <Fragment>
            <button className="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Notifications { `(${notifications.length})` }
            </button>
            <div className="dropdown-menu" aria-labelledby="dropdownMenuButton">
                { notifications.length == 0 && <a className="dropdown-item" href="#">No new notifications</a> }
                { notifications.length > 0 && 
                    <Fragment>
                        {
                            notifications.map(e => 
                                    e.type == NOTIFICATION_TYPES.journeyLiked && 
                                    <div>
                                        <a key={e.id} className="dropdown-item" href="#">{ e.data.sender_user_name } liked your journey</a>
                                    </div>          
                            )
                        }
                    </Fragment>
                } 
            </div> 
        </Fragment>
    )
}

const notifications = document.querySelector('.notifications');
ReactDOM.render(<Notifications />, notifications);