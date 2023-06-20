import React from "react";
import ReactDOM from 'react-dom/client';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Organizations from "./src/pages/Organizations";
import NewOrganization from "./src/pages/NewOrganization";
import NotFound from "./src/pages/NotFound";
import Branches from "./src/pages/Branches";
import NewBranch from "./src/pages/NewBranch";
import Cars from "./src/pages/Cars";
import NewCar from "./src/pages/NewCar";
import Car from "./src/pages/Car";
import Home from "./src/pages/Home";
import Organization from "./src/pages/Organization";
import Branch from "./src/pages/Branch";

const container = document.getElementById("servicePanelApp");
const root = ReactDOM.createRoot(container);

root.render(
    <BrowserRouter basename="/service-panel">
        <Routes>
            <Route path="/" element={<Home/>} />
            <Route path="/organizations" element={<Organizations/>} />
            <Route path="/organizations/new" element={<NewOrganization/>} />
            <Route path="/organizations/:id" element={<Organization/>} />
            <Route path="/organizations/:id/branches" element={<Branches/>} />
            <Route path="/organizations/:id/branches/new" element={<NewBranch/>} />
            <Route path="/organizations/:id/branches/:branchId" element={<Branch/>} />
            <Route path="/organizations/:id/branches/:branchId/cars" element={<Cars/>}/>
            <Route path="/organizations/:id/branches/:branchId/cars/new" element={<NewCar/>} />
            <Route path="/organizations/:id/branches/:branchId/cars/:carId" element={<Car/>} />
            <Route path="*" element={<NotFound/>} />
        </Routes>
    </BrowserRouter>
);