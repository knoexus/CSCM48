import React, { Fragment, useState } from 'react';
import ReactDOM from 'react-dom';

export default function Comments({data, journey}) {
    const [uData, changeUData] = useState(data);
    const [commentValue, changeCommentValue] = useState('');
    const submitForm = e => {
        e.preventDefault();
        console.log('ready to submit', commentValue);
        axios
            .post(`/users/${journey.user_id}/journeys/${journey.id}/comments`, {
                body: commentValue
            })
            .then(res => {
                console.log(res);
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
    return (
        <Fragment>
            <h4>Comments</h4>
            <form onSubmit={e => submitForm(e)}>
                <div className="form-group mt-3">
                    {/* <input type="hidden" name="_token" value={csrf} /> */}
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
            </div>
        </Fragment>
    )
}


const comments = document.querySelector('.comments');
// const data = JSON.parse(comments.dataset.comments);
const data = xcomments;
const journey = xjourney;
// const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
ReactDOM.render(<Comments data={data} journey={journey}/>, comments);