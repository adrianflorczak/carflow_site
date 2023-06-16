import * as React from "react";
import {Link} from "react-router-dom";

const BranchNavigation = ( {id} ) => {
    return(
        <>
            <ul className="nav nav-pills" style={{marginBottom: '15px'}}>
                <li role="presentation">
                    <Link to={`/organization/${id}`}>Wszystkie oddziały</Link>
                </li>
                <li role="presentation">
                    <Link to={`/organization/${id}/new-branch`}>Nowy oddział</Link>
                </li>
            </ul>
        </>
    );
}

export default BranchNavigation;