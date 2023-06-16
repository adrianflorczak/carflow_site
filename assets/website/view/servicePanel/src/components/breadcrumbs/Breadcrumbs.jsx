import * as React from "react";
import {Link} from "react-router-dom";

const Breadcrumbs = ({children}) => {
    return(
        <>
            <ol className="breadcrumb" style={{marginTop: '15px'}}>
                <li><a href="/">Strona główna</a></li>
                {children}
            </ol>
        </>
    );
}

export default Breadcrumbs;