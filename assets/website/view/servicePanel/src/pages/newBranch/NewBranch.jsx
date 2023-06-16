import * as React from "react";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import BranchNavigation from "../../components/branchNavigation/BranchNavigation";
import {useNavigate, useParams} from "react-router-dom";
import axios from "axios";
import {useFormik} from "formik";

const NewBranch = () => {
    let { id } = useParams();
    const navigate = useNavigate();

    const SendFormWithData = (values) => {
        axios
            .post(
                `/api/v-0-0-1/organizations/${id}/branches/new`,
                JSON.stringify(values)
            )
            .then((response) => {
                alert('Proces dodawania nowego oddziału zakończony powodzeniem.');
                navigate(`/organization/${id}`);
            })
            .catch((error) => {
                console.log({
                    'git': false,
                    error: error
                })
            })
    }

    const formik = useFormik({
        initialValues: {
            name: '',
            slug: ''
        },
        onSubmit: values => {
            SendFormWithData(values);
        }
    });

    return(
        <>
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text="Panel serwisowy: Organizacje" />
                <BreadcrumbsLinkItem url={`/organization/${id}`} text={`Organizacja: ${id}`} />
                <BreadcrumbsActiveItem text={`Nowy oddział`} />
            </Breadcrumbs>
            <div>
                <BranchNavigation id={id} />
                <form onSubmit={(e) => {e.preventDefault(); formik.handleSubmit(e)}}>

                    <div className="form-group">
                        <label htmlFor="name">Nazwa</label>
                        <input id="name" name="name" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.name}/>
                    </div>

                    <div className="form-group">
                        <label htmlFor="slug">Slug</label>
                        <input id="slug" name="slug" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.slug}/>
                    </div>

                    <button type="submit" className="btn btn-success">Zapisz</button>

                </form>
            </div>
        </>
    );
}

export default NewBranch;