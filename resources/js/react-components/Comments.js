import React, { Fragment, useState } from 'react';
import ReactDOM from 'react-dom';

export default function Comments({data, journey}) {
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

    return (
        <Fragment>
            <h4>Comments</h4>
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
                                        {/* @if (Auth::user())
                                            @if (Auth::user()->id == $comment->user->id)
                                                <a className="btn btn-outline-info" href="#" role="button">Edit comment</a>
                                            @endif
                                        @endif */}
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
// const data = JSON.parse(comments.dataset.comments);
const data = xcomments;
const journey = xjourney;
ReactDOM.render(<Comments data={data} journey={journey}/>, comments);