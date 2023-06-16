import * as React from "react";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import CarNavigation from "../../components/carNavigation/CarNavigation";
import {useParams} from "react-router-dom";

const NewCar = () => {
    let { id, branchId } = useParams();
    return(
        <>
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy: Organizacje'} />
                <BreadcrumbsLinkItem url={`/organization/${id}`} text={`Organizacja: ${id}`} />
                <BreadcrumbsLinkItem url={`/organization/${id}`} text={`Organizacja: ${id}/branch/${branchId}`} text={`Oddział: ${branchId}`}/>
                <BreadcrumbsActiveItem text={'Nowy pojazd'} />
            </Breadcrumbs>
            <CarNavigation/>
            FORMULARZ nowego pojazdu
        </>
    );
}

export default NewCar;