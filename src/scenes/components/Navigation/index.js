import React, { Component } from 'react';
import {Link, withRouter} from 'react-router-dom';
import './../../stayles/Navigation.css';

class Navigation extends Component {

    render() {

        return (
            <div>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
                    <a className="navbar-brand" href="#">Job Posts</a>
                    <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav">
                            <li className="nav-item active">
                                <Link className="nav-link" to="/">Create job <span className="sr-only">(current)</span></Link>
                            </li>
                            <li className="nav-item">
                                <Link className="nav-link" to="/view-job">View job</Link>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        )
    }

}

export default withRouter(Navigation);