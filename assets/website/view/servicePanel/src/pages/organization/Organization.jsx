import * as React from "react";
import {Link, useParams} from "react-router-dom";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";
import BranchNavigation from "../../components/branchNavigation/BranchNavigation";
import {useEffect, useState} from "react";
import axios from "axios";

const Organization = () => {
    const [error, setError] = useState(null);
    const [readyState, setReadyState] = useState(3);
    const [branches, setBranches] = useState(null);

    let { id } = useParams();

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

    if (readyState === 3) {
        return(
            <>
                <Breadcrumbs>
                    <BreadcrumbsLinkItem url={'/'} text="Panel serwisowy: Organizacje" />
                    <BreadcrumbsActiveItem text={`Organizacja: ${id}`} />
                </Breadcrumbs>
                <div>
                    <BranchNavigation id={id} />
                    Trwa ładowanie
                </div>
            </>
        );
    }

    if (readyState === 4) {
        if (error) {
            return(
                <>
                    <Breadcrumbs>
                        <BreadcrumbsLinkItem url={'/'} text="Panel serwisowy: Organizacje" />
                        <BreadcrumbsActiveItem text={`Organizacja: ${id}`} />
                    </Breadcrumbs>
                    <div>
                        <BranchNavigation id={id} />
                        <p>
                            {error.code}: {error.message}
                        </p>
                    </div>
                </>
            );
        } else {
            if (branches.length > 0) {
                return(
                    <>
                        <Breadcrumbs>
                            <BreadcrumbsLinkItem url={'/'} text="Panel serwisowy: Organizacje" />
                            <BreadcrumbsActiveItem text={`Organizacja: ${id}`} />
                        </Breadcrumbs>
                        <div>
                            <BranchNavigation id={id} />
                            <ul>
                                {branches.map(branch => (
                                    <li key={branch.id}>
                                        <Link to={`./branch/${branch.id}`}>
                                            {branch.name} (Zarządzaj oddziałem, Edytuj oddział, Usuń oddział)
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </>
                );
            } else {
                return(
                    <>
                        <Breadcrumbs>
                            <BreadcrumbsLinkItem url={'/'} text="Panel serwisowy: Organizacje" />
                            <BreadcrumbsActiveItem text={`Organizacja: ${id}`} />
                        </Breadcrumbs>
                        <div>
                            <BranchNavigation id={id} />
                            Obecnie nie posiadasz aktywnych oddziałów.
                            W celu utworzenia nowego oddziału <Link to={'./new-branch'}>kliknij tutaj</Link>.
                        </div>
                    </>
                );
            }
        }
    }


}

export default Organization;