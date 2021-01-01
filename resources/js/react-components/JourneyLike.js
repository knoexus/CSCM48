import React, { Fragment, useState } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


export default function JourneyLike({ id, journey_id, like_id, like_count }) {
    const [count, changeCount] = useState(parseInt(like_count));
    const [_like_id, changeLikeId] = useState(like_id);
    const [isLiked, changeIsLiked] = useState(!(like_id == 'null'));
    const toggleLike = () => {
        if (!isLiked) {
            axios
                .post(`/users/${id}/journeys/${journey_id}/likes`)
                .then(res => {
                    changeCount(count+1);
                    changeLikeId(res.data.likeId)
                    changeIsLiked(true);
                })
                .catch(err => {
                    console.error(err);
                    if (err.response.status == 401) {
                        window.location.href = '/login';
                    }
                });
        }
        else {
            axios
                .delete(`/users/${id}/journeys/${journey_id}/likes/${_like_id}`)
                .then(() => {
                    changeCount(count-1);
                    changeIsLiked(false);
                })
                .catch(err => console.error(err));
        }
    }
    return (
        <Fragment>
            <div onClick={() => toggleLike()} className={`likeGlyph ${isLiked ? 'likeGlyph-entered' : ''}`}>
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 18" width="24" height="24"><path className="heroicon-ui" d="M12.76 3.76a6 6 0 0 1 8.48 8.48l-8.53 8.54a1 1 0 0 1-1.42 0l-8.53-8.54a6 6 0 0 1 8.48-8.48l.76.75.76-.75zm7.07 7.07a4 4 0 1 0-5.66-5.66l-1.46 1.47a1 1 0 0 1-1.42 0L9.83 5.17a4 4 0 1 0-5.66 5.66L12 18.66l7.83-7.83z" /></svg>
                <span>{count}</span>
            </div>
        </Fragment>
    )
}

const els = document.querySelectorAll('.like');
if (els.length > 0) {
    els.forEach(el => {
        const id = el.getAttribute('data-uId');
        const journey_id = el.getAttribute('data-journeyId');
        const like_id = el.getAttribute('data-likeId');
        const like_count = el.getAttribute('data-likeCount');
        ReactDOM.render(<JourneyLike id={id} journey_id={journey_id} like_id={like_id} like_count={like_count} />, el);
    });
}