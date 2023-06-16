import * as React from "react";
import {Link, useParams} from "react-router-dom";

const CarNavigation = () => {
    let { id, branchId } = useParams();
    return(
        <>
            <ul className="nav nav-pills" style={{marginBottom: '15px'}}>
                <li role="presentation">
                    <Link to={`/organization/${id}/branch/${branchId}`}>Wszystkie pojazdy</Link>
                </li>
                <li role="presentation">
                    <Link to={`/organization/${id}/branch/${branchId}/new-car`}>Nowy pojazd</Link>
                </li>
            </ul>
        </>
    );
}

export default CarNavigation;