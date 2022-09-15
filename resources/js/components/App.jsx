import React, {Component} from "react";
import {BrowserRouter as Router, Route, Link} from "react-router-dom";
import ReactDOM from 'react-dom';
import Show from "./Show";
import Create from "./Create";

class App extends Component {

    render() {
        return (
            <Router>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div className="container">
                        <a className="navbar-brand" href="/">School</a>
                        <div className="collapse navbar-collapse" id="navbarNav">
                            <ul className="navbar-nav">
                                <li className="nav-item active">
                                    <Link to="/" className="nav-link">Students</Link>
                                </li>
                                <li className="nav-item">
                                    <Link to="/create-student-record" className="nav-link">Create Record</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div className="container">
                <br/>
                <Route path="/" exact component={Show}/>
                <Route path="/create-student-record" component={Create}/>
                <Route path="/update-student-record/:studentId" component={Create}/>
                </div>
            </Router>
        );
    }
}

export default App;

if (document.getElementById('root')) {
    ReactDOM.render(<App />, document.getElementById('root'));

}
