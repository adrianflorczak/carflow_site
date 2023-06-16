import * as React from "react";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import {useParams} from "react-router-dom";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";
import CarNavigation from "../../components/carNavigation/CarNavigation";

const Branch = () => {
    let { id, branchId } = useParams();



    return(
        <>
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy: Organizacje'} />
                <BreadcrumbsLinkItem url={`/organization/${id}`} text={`Organizacja: ${id}`} />
                <BreadcrumbsActiveItem text={`Oddział: ${branchId}`} />
            </Breadcrumbs>
            <CarNavigation/>
            Branch Page
        </>
    );
}

export default Branch;