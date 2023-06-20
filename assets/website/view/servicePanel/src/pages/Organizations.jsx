import * as React from 'react';
import {useEffect, useState} from "react";
import axios from "axios";
import {Link} from "react-router-dom";
import OrganizationsNavigation from "../components/organizationsNavigation/OrganizationsNavigation";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";

const Organizations = () => {
    const [readyState, setReadyState] = useState(3);
    const [organizations, setOrganizations] = useState([]);
    const [error, setError] = useState({
        code: null,
        message: null
    });

    useEffect(() => {
        axios
            .get('/api/v-0-0-1/organizations')
            .then((response) => {
                setReadyState(4);
                setOrganizations(response.data);
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
                <BreadcrumbsActiveItem text={'Organizacje'}/>
            </Breadcrumbs>
        );
    }

    if (readyState === 3) {
        return(
            <section>
                <h2 style={{display: "none"}}>Trwa ładowanie</h2>
                <PageBreadcrumbs/>
                <OrganizationsNavigation/>
                Trwa ładowanie danych ...
            </section>
        );
    }

    if (readyState === 4) {
        if (error.code) {
            return(
                <section>
                    <h2 style={{display: "none"}}>Błąd pobierania danych</h2>
                    <PageBreadcrumbs/>
                    <OrganizationsNavigation/>
                    <p>
                        {error.code}: {error.message}
                    </p>
                </section>
            );
        } else {
            if (organizations.length > 0) {
                return(
                    <section>
                        <h2 style={{display: "none"}}>Organizacje</h2>
                        <PageBreadcrumbs/>
                        <OrganizationsNavigation/>
                            {organizations.map(organization => (
                                <div className="jumbotron text-center" key={organization.id}>
                                    <h3>{organization.name}</h3>
                                    <p>
                                        Liczba zarejestrowanych oddziałów: x<br/>
                                        Liczba zarejestrowanych samochodów: x
                                    </p>
                                    <div className="btn-group" role="group" aria-label="...">

                                        <Link className="btn btn-primary btn-xs" to={`/organizations/${organization.id}`} role="button">
                                            Pokaż
                                        </Link>
                                        <Link className="btn btn-warning btn-xs" to={'/'} role="button" disable="disable">
                                            Edytuj
                                        </Link>
                                        <Link className="btn btn-danger btn-xs" to={'/'} role="button">
                                            Usuń
                                        </Link>
                                    </div>
                                </div>
                                // <li key={organization.id}>
                                //     <Link to={`/organizations/${organization.id}`}>
                                //         {organization.name} (Zarządzaj organizacją, Edytuj organziację, Usuń organizację)
                                //     </Link>
                                // </li>
                            ))}
                    </section>
                );
            } else {
                return (
                    <>
                        <PageBreadcrumbs/>
                        <OrganizationsNavigation/>
                        Obecnie nie posiadasz aktywnych organizjacji.
                        W celu utworzenia nowej organizacji <Link to={'/organizations/new'}>kliknij tutaj</Link>.
                    </>
                );
            }
        }
    }
}

export default Organizations;