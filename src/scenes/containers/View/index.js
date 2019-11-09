import React, { Component } from 'react';
import { withRouter} from 'react-router-dom';
import './../../stayles/Navigation.css';
import {PostsTable} from "../../components/Table/posts-table";
import {read} from "../../components/UserFunctions";

class View extends Component {

    constructor(props) {
        super(props);

        this.state = {
            tableData: []
        }
    }

    componentDidMount() {

        read().then(tableData =>

            this.setState({
                tableData: tableData.data
            })

        )

    }

    componentWillUnmount() {
        //ToDo
    }

    render() {

        const dataTable = this.state.tableData.map(function (item) {

                return item;

        });

        return (
            <div className='container-fluid'>
                <div className='row'>
                    <div className='col-lg-12'>
                        {dataTable.length > 0 ?
                            <PostsTable data={dataTable}>
                            </PostsTable>
                            : false }
                    </div>
                </div>
            </div>
        )
    }

}

export default withRouter(View);