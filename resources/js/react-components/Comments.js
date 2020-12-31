import React, { Fragment, useState } from 'react';
import ReactDOM from 'react-dom';

export default function Comments({data, journey, uId, admin}) {
    const hardLimit = 5;
    const [uData, changeUData] = useState(data);
    const [noFetch, changeNoFetch] = useState(data.length < hardLimit);
    const [commentValue, changeCommentValue] = useState('');
    const submitForm = e => {
        e.preventDefault();
        console.log('ready to submit', commentValue);
        axios
            .post(`/users/${journey.user_id}/journeys/${journey.id}/comments`, {
                body: commentValue
            })
            .then(res => {
                changeUData(() => {
                    const obj = {
                        ...res.data.comment,
                        user: {
                            ...res.data.user
                        }
                    }
                    return [obj, ...uData]
                })
            })
            .catch(err => console.error(err));
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
                console.log(res);
                // remove from comments
                changeUData([...uData].filter(el => el.id !== cId));
            })
            .catch(err => console.error(err));
    }

    return (
        <Fragment>
            <h4>Comments {`(${uData.length})`}</h4>
            <form onSubmit={e => submitForm(e)}>
                <div className="form-group mt-3">
                    <label>New comment:</label>
                    <textarea onChange={e => changeCommentValue(e.target.value)} name="body" className="form-control" rows="2" placeholder="Comment"></textarea>
                    {/* @if ($errors->has('body'))
                        <span className="text-danger">{{ $errors->first('body') }}</span>
                    @endif */}
                </div>
                <button type="submit" className="btn btn-primary">Submit</button>
            </form>
            <div>
                {
                    uData.length == 0 ? 
                        <span>No comments</span> 
                        :
                        <Fragment>
                            {
                                uData.map(comment => 
                                    <div key={comment.id} className="col-sm-2 col-xl-2 border">
                                        <span>{ comment.body }</span>
                                        <span>Created at { comment.created_at }</span>
                                        <span>Posted by <a className="user-username" href={`/users/${comment.user.id}`}>{ comment.user.user_name }</a></span>
                                        { (comment.user.id == uId || admin) && <button onClick={e => deleteComment(e, comment.id)} type="button" className="btn btn-danger" role="button">X</button> }
                                    </div>
                                )
                            }
                        </Fragment>

                }
                { !noFetch && <button onClick={() => fetchNext()}>Fetch next 5 comments</button> }
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
if (comments && data && journey) {
    ReactDOM.render(<Comments data={data} admin={xadmin} journey={journey} uId={uId}/>, comments);
}