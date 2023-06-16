import * as React from 'react';
import {useEffect, useState} from "react";
import axios from "axios";
import {Link} from "react-router-dom";
import OrganizationsNavigation from "../../components/organizationsNavigation/OrganizationsNavigation";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";

const Home = () => {
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
                setOrganizations(response.data.organizations);
            })
            .catch((error) => {
                setReadyState(4);
                setError({code: error.code, message: error.message});
            })
    }, []);

    if (readyState === 3) {
        return(
            <>
                <Breadcrumbs>
                    <BreadcrumbsActiveItem text="Panel serwisowy: Organizacje"/>
                </Breadcrumbs>
                <OrganizationsNavigation/>
                Trwa ładowanie danych ...
            </>
        );
    }

    if (readyState === 4) {
        if (error.code) {
            return(
                <>
                    <Breadcrumbs>
                        <BreadcrumbsActiveItem text="Panel serwisowy: Organizacje"/>
                    </Breadcrumbs>
                    <OrganizationsNavigation/>
                    <p>
                        {error.code}: {error.message}
                    </p>
                </>
            );
        } else {
            if (organizations.length > 0) {
                return(
                    <>
                        <Breadcrumbs>
                            <BreadcrumbsActiveItem text="Panel serwisowy: Organizacje"/>
                        </Breadcrumbs>
                        <OrganizationsNavigation/>
                        <ul>
                            {organizations.map(organization => (
                                <li key={organization.id}>
                                    <Link to={`/organization/${organization.id}`}>
                                        {organization.name} (Zarządzaj organizacją, Edytuj organziację, Usuń organizację)
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </>
                );
            } else {
                return (
                    <>
                        <Breadcrumbs>
                            <BreadcrumbsActiveItem text="Panel serwisowy: Organizacje"/>
                        </Breadcrumbs>
                        <OrganizationsNavigation/>
                        Obecnie nie posiadasz aktywnych organizjacji.
                        W celu utworzenia nowej organizacji <Link to={'/new-organization'}>kliknij tutaj</Link>.
                    </>
                );
            }
        }
    }
}

export default Home;