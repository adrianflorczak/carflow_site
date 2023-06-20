import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import {Link, useNavigate, useParams} from "react-router-dom";
import {useEffect, useState} from "react";
import axios from "axios";

const Car = () => {
    const navigate = useNavigate();
    const {id, branchId, carId} = useParams();
    const [readyState, setReadyState] = useState(3);
    const [car, setCar] = useState([]);
    const [error, setError] = useState({
        code: null,
        message: null
    });

    useEffect(() => {
        axios
            .get(`/api/v-0-0-1/organizations/${id}/branches/${branchId}/cars/${carId}`)
            .then((response) => {
                setReadyState(4);
                setCar(response.data);
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
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches/${branchId}/cars`} text={`Samochody`}/>
                <BreadcrumbsActiveItem text={`${carId}`}/>
            </Breadcrumbs>
        );
    }

    if (readyState === 3) {
        return (
            <>
                <PageBreadcrumbs/>
                Trwa ładowanie danych ...
            </>
        );
    }

    if (readyState === 4) {
        if (error.code) {
            return (
                <>
                    <PageBreadcrumbs/>
                    <p>
                        {error.code}: {error.message}
                    </p>
                </>
            );
        } else {
            if (car) {
                return (
                    <>
                        <PageBreadcrumbs/>
                        Marka: {car.brand} (edytuj)<br/>
                        Model: {car.model} (edytuj)<br/>

                    </>
                );
            } else {
                navigate('/not-found')
            }
        }
    }


}

export default Car;