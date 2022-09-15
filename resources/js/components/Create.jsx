import React, {Component} from "react";
import {Oval, ThreeDots} from "react-loader-spinner";
import {storeRecord, studentData, updateRecord} from "./util/server";
import {Redirect} from "react-router-dom";

class Create extends Component {

    constructor(props) {
        super(props);
        this.state = {
            firstName:"",
            lastName:"",
            idNumber:"",
            country:"",
            dateOfBirth:"",
            registeredOn:"",
            student:"",
            id: (props.match.params.studentId !== undefined)?props.match.params.studentId : null,
            error:"Something went wrong please try again later",
            redirect:false,
            loader: false,
            onSubmit:false
        };
        this._isMounted = false;
    }

    componentDidMount() {
        this._isMounted = true;
        if(this.state.id !== null) {
            this.getStudentData();
        }
    }

    getStudentData(){
        this.setState({loader: true});

        studentData(this.state.id).then((response) => {
            if (this._isMounted) {
                if(response.status === 200) {
                    this.setState({
                        firstName: response.data.student.first_name,
                        lastName: response.data.student.last_name,
                        idNumber: response.data.student.identification_no,
                        country: response.data.student.country,
                        dateOfBirth: response.data.student.date_of_birth,
                        registeredOn: response.data.student.registered_on,
                        loader:false
                    });
                }else{
                    this.setState({student: null});
                }
            }
        }).catch((error) =>  {
            this.setState({student: null, loader:false});
            throw Error(error.message);
        });
    }

    handleSubmit = (e) => {
        e.preventDefault();
        const {firstName, lastName, idNumber, country, dateOfBirth, registeredOn} = this.state;
        this.setState({onSubmit: true});

        if(this.state.id !== null){
            updateRecord(firstName, lastName, idNumber, country, dateOfBirth, registeredOn, this.state.id).then((response) => {
                this.setState({onSubmit: false});
                if (this._isMounted) {
                    if (response.status === 200) {
                        this.setState({redirect: true});
                    }
                }
            }).catch((error) => {
                this.setState({onSubmit: false})
                throw Error(error.message)
            });
        }else {
            storeRecord(firstName, lastName, idNumber, country, dateOfBirth, registeredOn).then((response) => {
                this.setState({onSubmit: false});
                if (this._isMounted) {
                    if (response.status === 201) {
                        this.setState({redirect: true});
                    }
                }
            }).catch((error) => {
                this.setState({onSubmit: false})
                throw Error(error.message)
            });
        }
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    render() {
        const {firstName, lastName, idNumber, country, dateOfBirth, registeredOn} = this.state;

        if(this.state.redirect) {
            (this.state.id !== null)?sessionStorage.setItem("record", "Record updated"):sessionStorage.setItem("record", "Record created");
            return <Redirect to={{pathname:'/'}}/>
        }

        return (
            (!this.state.loader)?<div className="col-6 mx-auto">
                <h3 className="mb-4">Create Student Records</h3>

                <form onSubmit={this.handleSubmit}>
                    <div className="mb-3">
                        <label>First Name</label>
                        <input type="text" className="form-control" value={firstName} onChange={e => this.setState({firstName:e.target.value})} required/>
                    </div>
                    <div className="mb-3">
                        <label>Last Name</label>
                        <input type="text" className="form-control" value={lastName} onChange={e => this.setState({lastName:e.target.value})} required/>
                    </div>
                    <div className="mb-3">
                        <label>Identification Number</label>
                        <input type="number" className="form-control" value={idNumber} onChange={e => this.setState({idNumber:e.target.value})} required/>
                    </div>
                    <div className="mb-3">
                        <label>Country</label>
                        <input type="text" className="form-control" value={country} onChange={e => this.setState({country:e.target.value})} required/>
                    </div>
                    <div className="mb-3">
                        <label>Date of Birth</label>
                        <input type="datetime-local" className="form-control" value={dateOfBirth} onChange={e => this.setState({dateOfBirth:e.target.value})} required/>
                    </div>
                    <div className="mb-3">
                        <label>Registered On</label>
                        <input type="datetime-local" className="form-control" value={registeredOn} onChange={e => this.setState({registeredOn:e.target.value})} required/>
                    </div>
                    <div>
                        <button type="submit" className="btn btn-primary">{(!this.state.onSubmit)?"Submit record":
                            <ThreeDots height="25" width="30" radius="9" color="#ffffff" ariaLabel="three-dots-loading" wrapperStyle={{}} wrapperClassName="" visible={true}
                            />}</button>
                    </div>
                </form>
            </div>:<div className="col-6 mx-auto mt-5"><Oval type="Circles" color="#4287f5" height={50} width={50}/></div>
        )
    }
}

export default Create;
