import React, { Fragment, useState } from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';

export default function Comments({data, journey, uId, admin, commentCount}) {
    const hardLimit = 5;
    const [_commentCount, changeCommentCount] = useState(commentCount);
    const [uData, changeUData] = useState(data);
    const [noFetch, changeNoFetch] = useState(data.length < hardLimit);
    const [commentValue, changeCommentValue] = useState('');
    const [bodyError, changeBodyError] = useState(null);
    const submitForm = e => {
        e.preventDefault();
        changeBodyError(null);
        axios
            .post(`/users/${journey.user_id}/journeys/${journey.id}/comments`, {
                body: commentValue
            })
            .then(res => {
                if (res.data.errors) {
                    changeBodyError(res.data.errors[0]);
                }
                else {
                    changeCommentCount(_commentCount+1);
                    changeUData(() => {
                        const obj = {
                            ...res.data.comment,
                            user: {
                                ...res.data.user
                            }
                        }
                        return [obj, ...uData]
                    })
                }
            })
            .catch(err => {
                console.error(err);
                if (err.response.status == 401) {
                    window.location.href = '/login';
                }
            });
    }

    const fetchNext = () => {
        axios
            .get(`/users/${journey.user_id}/journeys/${journey.id}/comments`, {
                params: {
                    startId: uData[uData.length-1].id,
                    take: hardLimit
                }
            })
            .then(res => {
                const comments = res.data.comments;
                if (comments.length < hardLimit) {
                    changeNoFetch(true);
                }   
                changeUData([...uData, ...res.data.comments]);
            })
            .catch(err => console.error(err));
    }

    const deleteComment = (e, cId) => {
        e.preventDefault();
        axios
            .delete(`/users/${journey.user_id}/journeys/${journey.id}/comments/${cId}`)
            .then(res => {
                changeCommentCount(_commentCount-1);
                changeUData([...uData].filter(el => el.id !== cId));
            })
            .catch(err => console.error(err));
    }

    return (
        <Fragment>
            <h4>Comments {`(${_commentCount})`}</h4>
            <form onSubmit={e => submitForm(e)}>
                <div className="form-group mt-3">
                    <label>New comment:</label>
                    <textarea onChange={e => changeCommentValue(e.target.value)} name="body" className="form-control" rows="2" placeholder="Comment"></textarea>
                    { 
                        bodyError &&
                        <div className="mt-3 list-disc list-inside text-sm text-red-600">
                            <span className="text-danger">{bodyError}</span>
                        </div>
                    }
                </div>

                <button type="submit" className="btn btn-primary">Submit</button>
            </form>
            <div className="mt-3">
                {
                    uData.length == 0 ? 
                        <span>No comments</span> 
                        :
                        <Fragment>
                            {
                                uData.map(comment => 
                                    <div key={comment.id} className="mt-4 border journey-full-comment">
                                        <div className="journey-full-comment-username">
                                            <a className="user-username" href={`/users/${comment.user.id}`}>{ comment.user.user_name }</a>
                                        </div>
                                        <div className="journey-full-comment-body">
                                            <span>{ comment.body }</span>
                                        </div>
                                        <div className="posted posted-comment">
                                            <span>Created at { moment(comment.created_at).format('DD/MM/YYYY HH:mm') }</span>
                                        </div>
                                        { (comment.user.id == uId || admin) && <div className="delete-comment"><button onClick={e => deleteComment(e, comment.id)} type="button" className={`btn btn-${admin ? 'warning' : 'danger'}`} role="button">X</button></div> }
                                    </div>
                                )
                            }
                        </Fragment>

                }
                { !noFetch && <button className="btn btn-outline-secondary mt-5" onClick={() => fetchNext()}>Fetch next { hardLimit } comments ...</button> }
            </div>
        </Fragment>
    )
}


const comments = document.querySelector('.comments');
const uId = document.querySelector("meta[name='user-id']").getAttribute('content');
// const data = JSON.parse(comments.dataset.comments);
const data = window.xcomments || null;
const journey = window.xjourney || null;
const admin = window.xadmin || null;
const commentCount = window.xcommentcount || 0;
if (comments && data && journey && (commentCount !== undefined || (commentCount !== null))) {
    ReactDOM.render(<Comments data={data} admin={admin} journey={journey} uId={uId} commentCount={commentCount}/>, comments);
}