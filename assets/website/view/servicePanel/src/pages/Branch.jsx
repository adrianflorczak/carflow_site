import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import {useParams} from "react-router-dom";

const Branch = () => {

    const {id, branchId} = useParams();

    const PageBreadcrumbs = () => {
        return (
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy'}/>
                <BreadcrumbsLinkItem url={'/organizations'} text={'Organizacje'}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}`} text={`${id}`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches`} text={`Oddziały`}/>
                <BreadcrumbsActiveItem text={`${branchId}`}/>
            </Breadcrumbs>
        );
    }

    return(
        <>
            <PageBreadcrumbs/>
            Strona konkretnego oddziału
        </>
    );
}

export default Branch;