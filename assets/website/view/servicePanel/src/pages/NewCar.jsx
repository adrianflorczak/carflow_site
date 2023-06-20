import * as React from "react";
import Breadcrumbs from "../components/breadcrumbs/Breadcrumbs";
import BreadcrumbsLinkItem from "../components/breadcrumbs/BreadcrumbsLinkItem";
import BreadcrumbsActiveItem from "../components/breadcrumbs/BreadcrumbsActiveItem";
import CarNavigation from "../components/carNavigation/CarNavigation";
import {useNavigate, useParams} from "react-router-dom";
import axios from "axios";
import {useFormik} from "formik";

const NewCar = () => {
    let { id, branchId } = useParams();
    const navigate = useNavigate();

    const SendFormWithData = (values) => {
        axios
            .post(
                `/api/v-0-0-1/organizations/${id}/branches/${branchId}/cars`,
                JSON.stringify(values)
            )
            .then((response) => {
                alert('Proces dodawania nowego pojazdu zakończony powodzeniem.');
                navigate(`/organizations/${id}/branches/${branchId}/cars`);
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
            brand: '',
            model: '',
            vin: '',
            segment: '',
            bodyType: '',
            color: '',
            fuel: '',
            numberOfSeats: 0,
            numberOfDoors: 0,
            registrationNumber: '',
            technicalExaminationDate: '',
            insuranceExpirationDate: '',
            mileage: 0,
        },
        onSubmit: values => {
            SendFormWithData(values);
        }
    });

    const PageBreadcrumbs = () => {
        return (
            <Breadcrumbs>
                <BreadcrumbsLinkItem url={'/'} text={'Panel serwisowy'}/>
                <BreadcrumbsLinkItem url={'/organizations'} text={'Organizacje'}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}`} text={`${id}`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches`} text={`Oddziały`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches/${branchId}`} text={`${branchId}`}/>
                <BreadcrumbsLinkItem url={`/organizations/${id}/branches/${branchId}/cars`} text={`Samochody`}/>
                <BreadcrumbsActiveItem text={`Nowy`}/>
            </Breadcrumbs>
        );
    }

    return(
        <>
            <PageBreadcrumbs/>
            <CarNavigation/>
            <form onSubmit={(e) => {e.preventDefault(); formik.handleSubmit(e)}}>

                <div className="form-group">
                    <label htmlFor="brand">Marka</label>
                    <input id="brand" name="brand" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.brand} placeholder="Marka"/>
                </div>

                <div className="form-group">
                    <label htmlFor="model">Model</label>
                    <input id="model" name="model" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.model} placeholder="Model"/>
                </div>

                <div className="form-group">
                    <label htmlFor="vin">VIN</label>
                    <input id="vin" name="vin" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.vin} placeholder="VIN"/>
                </div>

                <div className="form-group">
                    <label htmlFor="segment">Segment</label>
                    <input id="segment" name="segment" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.segment} placeholder="Segment"/>
                </div>

                <div className="form-group">
                    <label htmlFor="bodyType">Nadwozie</label>
                    <input id="bodyType" name="bodyType" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.bodyType} placeholder="Nadwozie"/>
                </div>

                <div className="form-group">
                    <label htmlFor="color">Kolor</label>
                    <input id="color" name="color" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.color} placeholder="Kolor"/>
                </div>

                <div className="form-group">
                    <label htmlFor="fuel">Paliwo</label>
                    <input id="fuel" name="fuel" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.fuel} placeholder="Paliwo"/>
                </div>

                <div className="form-group">
                    <label htmlFor="numberOfSeats">Liczba miejsc</label>
                    <input id="numberOfSeats" name="numberOfSeats" type="number" min="1" max="9" className="form-control" onChange={formik.handleChange} value={formik.values.numberOfSeats} placeholder="Liczba miejsc"/>
                </div>

                <div className="form-group">
                    <label htmlFor="numberOfDoors">Liczba drzwi</label>
                    <input id="numberOfDoors" name="numberOfDoors" type="number" min="1" max="5" className="form-control" onChange={formik.handleChange} value={formik.values.numberOfDoors} placeholder="Liczba drzwi"/>
                </div>

                <div className="form-group">
                    <label htmlFor="registrationNumber">Numer rejestracyjny</label>
                    <input id="registrationNumber" name="registrationNumber" type="text" className="form-control" onChange={formik.handleChange} value={formik.values.registrationNumber} placeholder="Numer rejestracyjny"/>
                </div>

                <div className="form-group">
                    <label htmlFor="technicalExaminationDate">Data badania technicznego</label>
                    <input id="technicalExaminationDate" name="technicalExaminationDate" type="date" className="form-control" onChange={formik.handleChange} value={formik.values.technicalExaminationDate} />
                </div>

                <div className="form-group">
                    <label htmlFor="insuranceExpirationDate">Data polisy ubezpieczeniowej</label>
                    <input id="insuranceExpirationDate" name="insuranceExpirationDate" type="date" className="form-control" onChange={formik.handleChange} value={formik.values.insuranceExpirationDate} />
                </div>

                <div className="form-group">
                    <label htmlFor="mileage">Przebieg</label>
                    <input id="mileage" name="mileage" type="number" min="1" className="form-control" onChange={formik.handleChange} value={formik.values.mileage} placeholder="Przebieg"/>
                </div>

                <button type="submit" className="btn btn-success">Zapisz</button>

            </form>
        </>
    );
}

export default NewCar;