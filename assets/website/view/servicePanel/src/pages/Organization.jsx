import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import {useParams} from "react-router-dom";

const Organization = () => {

    const { id } = useParams();

    const PageBreadcrumbs = () => {
        return (
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy'}/>
                <BreadcrumbsLinkItem url={'/organizations'} text={'Organizacje'}/>
                <BreadcrumbsActiveItem text={`${id}`}/>
            </Breadcrumbs>
        );
    }

    return(
        <>
            <PageBreadcrumbs/>
            Strona konkretnej organizacji
        </>
    );
}

export default Organization;