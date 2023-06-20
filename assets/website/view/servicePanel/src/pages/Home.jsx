import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import {Link} from "react-router-dom";
import {useEffect, useState} from "react";
import axios from "axios";

const Home = () => {

    const [readyState, setReadyState] = useState(3);
    const [count, setCount] = useState(null);
    const [error, setError] = useState({
        code: null,
        message: null
    });

    useEffect(() => {
        axios
            .get(`/api/v-0-0-1/organizations/count`)
            .then((response) => {
                setReadyState(4);
                setCount(response.data);
            })
            .catch((error) => {
                setReadyState(4);
                setError({code: error.code, message: error.message});
            })
    }, []);

    const PageBreadcrumbs = () => {
        return (
            <Breadcrumbs>
                <BreadcrumbsActiveItem text={'Panel serwisowy'}/>
            </Breadcrumbs>
        );
    }

    const OrganizationSection = ( {children} ) => {
        return(
            <section>
                <h2 style={{display: "none"}}>Organizacje</h2>
                Strona główna serwisu obsługi, tutaj jakies fajne wykresy, widgety, skróty, itd.<br/><br/>
                <div className="jumbotron text-center">
                    <p>Organizacje</p>
                    {children}
                    <p>
                        <Link to={`/organizations/new`}><button className="btn btn-success">Zarejestruj nową organizację</button></Link>
                        <br/><br/>
                        <Link to={`/organizations`}><button className="btn btn-primary">Pokaż zarejestrowane organizacje</button></Link>
                    </p>
                </div>
            </section>
        );
    }


    if (readyState === 3) {
        return(
            <>
                <PageBreadcrumbs/>
                <OrganizationSection>
                    <p>
                        Trwa ładowanie...
                    </p>
                </OrganizationSection>
            </>
        );
    }

    if (readyState === 4) {
        if (error.code) {
            return(
                <>
                    <PageBreadcrumbs/>
                    <OrganizationSection>
                        <p>
                            Podczas pobierania danych wystapił błąd.
                        </p>
                    </OrganizationSection>
                </>
            );
        } else {
            return(
                <>
                    <PageBreadcrumbs/>
                    <OrganizationSection>
                        <p>
                            ( {count} )
                        </p>
                    </OrganizationSection>
                </>
            );
        }
    }
}

export default Home;