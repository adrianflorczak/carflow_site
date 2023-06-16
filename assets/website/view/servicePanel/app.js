import React from "react";
import ReactDOM from 'react-dom/client';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Home from "./src/pages/home/Home";
import NewOrganization from "./src/pages/newOrganization/NewOrganization";
import NotFound from "./src/pages/notFound/NotFound";
import Organization from "./src/pages/organization/Organization";
import NewBranch from "./src/pages/newBranch/NewBranch";
import Branch from "./src/pages/branch/Branch";
import NewCar from "./src/pages/newCar/NewCar";

const container = document.getElementById("servicePanelApp");
const root = ReactDOM.createRoot(container);

root.render(
    <BrowserRouter basename="/service-panel">
        <Routes>
            <Route path="/" element={<Home/>} />
            <Route path="/new-organization" element={<NewOrganization/>} />
            <Route path="/organization/:id" element={<Organization/>} />
            <Route path="/organization/:id/new-branch" element={<NewBranch/>} />
            <Route path="/organization/:id/branch/:branchId" element={<Branch/>}/>
            <Route path="/organization/:id/branch/:branchId/new-car" element={<NewCar/>}/>
            <Route path="*" element={<NotFound/>} />
        </Routes>
    </BrowserRouter>
);