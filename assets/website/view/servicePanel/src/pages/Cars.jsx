import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import {Link, useParams} from "react-router-dom";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import CarNavigation from "../components/carNavigation/CarNavigation";
import {useEffect, useState} from "react";
import axios from "axios";
import OrganizationsNavigation from "../components/organizationsNavigation/OrganizationsNavigation";

const Cars = () => {
    let {id, branchId} = useParams();
    const [readyState, setReadyState] = useState(3);
    const [cars, setCars] = useState([]);
    const [error, setError] = useState({
        code: null,
        message: null
    });

    useEffect(() => {
        axios
            .get(`/api/v-0-0-1/organizations/${id}/branches/${branchId}/cars`)
            .then((response) => {
                setReadyState(4);
                setCars(response.data);
            })
            .catch((error) => {
                setReadyState(4);
                setError({code: error.code, message: error.message});
            })
    }, []);

    const PageBreadcrumbs = () => {
        return (
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy'}/>
                <BreadcrumbsLinkItem url={'/organizations'} text={'Organizacje'}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}`} text={`${id}`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches`} text={`Oddziały`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches/${branchId}`} text={`${branchId}`}/>
                <BreadcrumbsActiveItem text={`Samochody`}/>
            </Breadcrumbs>
        );
    }

    if (readyState === 3) {
        return (
            <>
                <PageBreadcrumbs/>
                <CarNavigation/>
                Trwa ładowanie
            </>
        );
    }

    if (readyState === 4) {
        if (error.code) {
            return (
                <>
                    <PageBreadcrumbs/>
                    <CarNavigation/>
                    <p>
                        {error.code}: {error.message}
                    </p>
                </>
            );
        } else {
            if (cars.length > 0) {
                return (
                    <>
                        <PageBreadcrumbs/>
                        <CarNavigation/>
                        <ul>
                            {cars.map(car => (
                                <li key={car.id}>
                                    <Link to={`/organizations/${id}/branches/${branchId}/cars/${car.id}`}>
                                        Id {car.id}: {car.brand} {car.model} (Zarządzaj pojazdem, Edytuj pojazd, Usuń pojazd)
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </>
                );
            } else {
                return (
                    <>
                        <PageBreadcrumbs/>
                        <CarNavigation/>
                        Obecnie nie posiadasz aktywnych pojazdów.
                        W celu utworzenia nowego pojazdu <Link to={`/organizations/${id}/branches/${branchId}/cars/new`}>kliknij tutaj</Link>.
                    </>
                );
            }
        }
    }
}

export default Cars;