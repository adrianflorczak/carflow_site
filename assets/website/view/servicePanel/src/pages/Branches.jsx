import * as React from "react";
import {Link, useParams} from "react-router-dom";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import BranchNavigation from "../components/branchNavigation/BranchNavigation";
import {useEffect, useState} from "react";
import axios from "axios";

const Branches = () => {
    const [error, setError] = useState(null);
    const [readyState, setReadyState] = useState(3);
    const [branches, setBranches] = useState(null);

    let { id , branchId} = useParams();

    useEffect(() => {
        axios
            .get(`/api/v-0-0-1/organizations/${id}/branches`)
            .then((response) => {
                setReadyState(4);
                setBranches(response.data);
                console.log(response);
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
                <BreadcrumbsActiveItem text={`Oddziały`}/>
            </Breadcrumbs>
        );
    }

    if (readyState === 3) {
        return(
            <section>
                <h2 style={{display: "none"}}>Trwa ładowanie</h2>
                <PageBreadcrumbs/>
                <div>
                    <BranchNavigation id={id} />
                    Trwa ładowanie
                </div>
            </section>
        );
    }

    if (readyState === 4) {
        if (error) {
            return(
                <section>
                    <h2 style={{display: "none"}}>Błąd pobierania danych</h2>
                    <PageBreadcrumbs/>
                    <div>
                        <BranchNavigation id={id} />
                        <p>
                            {error.code}: {error.message}
                        </p>
                    </div>
                </section>
            );
        } else {
            if (branches.length > 0) {
                return(
                    <section>
                        <h2 style={{display: "none"}}>Oddziały</h2>
                        <PageBreadcrumbs/>
                        <div>
                            <BranchNavigation id={id} />
                                {branches.map(branch => (
                                    <div>Napraw to</div>
                                    // <div className="jumbotron">
                                    //     <h3>Hello, world!</h3>
                                    //     <p>...</p>
                                    //     <p><a className="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
                                    //     </p>
                                    // </div>
                                    // <li key={branch.id}>
                                    //     <Link to={`/organizations/${id}/branches/${branch.id}`}>
                                    //         {branch.name} (Zarządzaj oddziałem, Edytuj oddział, Usuń oddział)
                                    //     </Link>
                                    // </li>
                                ))}
                        </div>
                    </section>
                );
            } else {
                return(
                    <>
                        <PageBreadcrumbs/>
                        <div>
                            <BranchNavigation id={id} />
                            Obecnie nie posiadasz aktywnych oddziałów.
                            W celu utworzenia nowego oddziału <Link to={`/organizations/${id}/branches/new`}>kliknij tutaj</Link>.
                        </div>
                    </>
                );
            }
        }
    }


}

export default Branches;