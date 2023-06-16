import * as React from "react";
import {Link} from "react-router-dom";

const BreadcrumbsLinkItem = ({ url, text }) => {
    return(
        <li><Link to={url}>{text}</Link></li>
    );
}

export default BreadcrumbsLinkItem;