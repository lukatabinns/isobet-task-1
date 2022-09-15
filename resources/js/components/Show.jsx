import React, {Component} from "react";
import ReactDOM from 'react-dom';
import {Link} from "react-router-dom";
import {getStudents} from "./util/server";
import {Oval} from "react-loader-spinner";

class Show extends Component {

    constructor(props) {
        super(props);
        this.state = {
            error:"Something went wrong please try again later",
            loader: false,
            allStudents:null
        };
        this._isMounted = false;
    }

    componentDidMount() {
        this._isMounted = true;
        this.allStudents();
    }

    allStudents(){
        this.setState({loader: true});

        getStudents().then((response) => {
            if (this._isMounted) {
                if(response.status === 200) {
                    this.setState({allStudents: response.data.students, loader:false});
                }else{
                    this.setState({allStudents: null});
                }
            }
        }).catch((error) =>  {
            this.setState({allStudents: null, loader:false});
            throw Error(error.message);
        });
    }

    componentWillUnmount() {
        this._isMounted = false;
        sessionStorage.removeItem("record");
    }

    search(){
        let input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("student-record");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    render() {
        const studentRecord = sessionStorage.getItem("record");

        return (
            (this.state.allStudents !== null)?<div>
                <div className="row">
                    <div className="col-9"><h4>All Students</h4></div>
                    <div className="col-3">
                        <Link className="btn btn-primary" to="/create-student-record"><i className="fa fa-plus"/> Create Student Record</Link>
                        <div className="pt-3 pb-3 text-success"><h6>{(studentRecord !== null)?studentRecord:null}</h6></div>
                    </div>
                </div>

                { (this.state.allStudents.length > 0)?<>
                    <div className="mb-4 col-5"><input type="text" id="search" className="form-control" onKeyUp={this.search} placeholder="Search for names.." title="Type in a name"/></div>
                    <table className="table" id="student-record">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">IdentificationNo</th>
                                <th scope="col">Country</th>
                                <th scope="col">DateOfBirth</th>
                                <th scope="col">RegisteredOn</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                    {this.state.allStudents.map((value, i) =>
                        <tr key={i}>
                            <td>{value.first_name}</td>
                            <td>{value.last_name}</td>
                            <td>{value.identification_no}</td>
                            <td>{value.country}</td>
                            <td>{value.date_of_birth}</td>
                            <td>{value.registered_on}</td>
                            <td><Link to={`/update-student-record/${value.id}`}><i className="fa fa-edit"/></Link></td>
                        </tr>
                    )
                    }
                    </tbody>
                </table>
                </>:<h5>No data found</h5>}
            </div>:<div className="col-6 mx-auto mt-5"><Oval type="Circles" color="#4287f5" height={50} width={50}/></div>
        );
    }
}

export default Show;
