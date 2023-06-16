import * as React from "react";
import axios from "axios";
import {Link, useNavigate, useParams} from "react-router-dom";
import {Field, Form, Formik, useFormik} from "formik";
import OrganizationsNavigation from "../../components/organizationsNavigation/OrganizationsNavigation";
import Breadcrumbs from "../../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsActiveItem from "../../components/breadcrumbs/BreadcrumbsActiveItem";
import BreadcrumbsLinkItem from "../../components/breadcrumbs/BreadcrumbsLinkItem";


const NewOrganization = () => {

    const navigate = useNavigate();

    const SendFormWithData = (values) => {
        axios
            .post(
                '/api/v-0-0-1/organizations/new',
                JSON.stringify(values)
            )
            .then((response) => {
                alert('Proces dodawania nowej organizacji zakończony powodzeniem.');
                navigate('/');
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
            email: '',
            address: '',
            buildingAndApartmentNumber: '',
            postCode: '',
            city: '',
            country: '',
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
                <BreadcrumbsActiveItem text="Dodaj nową organizację"/>
            </Breadcrumbs>
            <OrganizationsNavigation/>
            <form onSubmit={(e) => {e.preventDefault(); formik.handleSubmit(e)}}>

                <div className="form-group">
                    <label htmlFor="name">Nazwa</label>
                    <input id="name" name="name" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.name}/>
                </div>

                <div className="form-group">
                    <label htmlFor="email">Email</label>
                    <input id="email" name="email" type="email" className="form-control" onChange={formik.handleChange} value={formik.values.email}/>
                </div>

                <div className="form-group">
                    <label htmlFor="address">Adres</label>
                    <input id="address" name="address" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.address}/>
                </div>

                <div className="form-group">
                    <label htmlFor="buildingAndApartmentNumber">Numer budynku oraz lokalu</label>
                    <input id="buildingAndApartmentNumber" name="buildingAndApartmentNumber" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.buildingAndApartmentNumber}/>
                </div>

                <div className="form-group">
                    <label htmlFor="postCode">Kod pocztowy</label>
                    <input id="postCode" name="postCode" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.postCode}/>
                </div>

                <div className="form-group">
                    <label htmlFor="city">Miasto</label>
                    <input id="city" name="city" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.city}/>
                </div>

                <div className="form-group">
                    <label htmlFor="country">Kraj</label>
                    <input id="country" name="country" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.country}/>
                </div>

                <div className="form-group">
                    <label htmlFor="slug">Slug</label>
                    <input id="slug" name="slug" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.slug}/>
                </div>

                <button type="submit" className="btn btn-success">Zapisz</button>

            </form>
        </>
    );
}

export default NewOrganization;