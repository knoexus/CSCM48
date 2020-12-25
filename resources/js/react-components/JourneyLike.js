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
                .catch(err => console.error(err));
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
            <button onClick={() => toggleLike()}>{ isLiked ? 'Unlike' : 'Like' }</button>
            <span>L: {count}</span>
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