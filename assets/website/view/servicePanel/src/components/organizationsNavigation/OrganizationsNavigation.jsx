import * as React from "react";
import {Link} from "react-router-dom";

const OrganizationsNavigation = () => {
    return(
        <>
            <ul className="nav nav-pills" style={{marginBottom: '15px'}}>
                <li role="presentation">
                    <Link to={'/'}>Wszystkie organizacje</Link>
                </li>
                <li role="presentation">
                    <Link to={'/new-organization'}>Nowa organizacja</Link>
                </li>
            </ul>
        </>
    );
}

export default OrganizationsNavigation;