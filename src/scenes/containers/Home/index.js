import React, { Component } from 'react';
import {withRouter} from 'react-router-dom';
import '../../stayles/Posts.css';
import {createUsers} from "../../components/UserFunctions";

class Home extends Component {

    constructor(props) {
        super(props);


        this.state = {
            form: {
                textAlign: 'center'
            },
            title : '',
            description : '',
            email : '',
            re : {
                'title' : /^[a-zA-Z\-,.!? ]+$/,
                'description'   : /^[a-zA-Z0-9\-+,.!? ]+$/,
                'email' : /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,

            }
        };

        this.handleChange = this.handleChange.bind(this);
        this.validate = this.validate.bind(this);
        this.submitForm = this.submitForm.bind(this);
    }

    validate(){
        return (this.state.title !== ''  && this.state.title.length > 0 && this.state.description !== ''
            && this.state.description.length >= 6 && this.state.email !== '' && this.state.email.length > 0
            && this.state.re.title.test( this.state.title )
            && this.state.re.description.test( this.state.description )
            && this.state.re.email.test( this.state.email )
        ) ? this.state.title && this.state.description && this.state.email : false;
    }

    handleChange = (e) => {
        this.setState(
            {
                [e.target.name]: e.target.value
            }
        );

        if(e.target.name === 'title'){
            if(e.target.value ==='' || e.target.value ===null || !this.state.re.title.test( e.target.value  ) ){
                this.setState({
                    titleError:true
                })
            } else {
                this.setState({
                    titleError:false,
                    title:e.target.value
                })
            }

        }

        if(e.target.name === 'description'){
            if(e.target.value ==='' || e.target.value ===null || !this.state.re.description.test( e.target.value  ) || !e.target.value.length >=6 ) {
                this.setState({
                    descriptionError:true
                })
            } else {
                this.setState({
                    descriptionError:false,
                    description:e.target.value
                })
            }
        }

        if(e.target.name === 'email'){
            if(e.target.value ==='' || e.target.value ===null || !this.state.re.email.test( e.target.value  ) || !e.target.value.length >=6 ) {
                this.setState({
                    emailError:true
                })
            } else {
                this.setState({
                    emailError:false,
                    email:e.target.value
                })
            }
        }
    };

    submitForm = (e) => {
        e.preventDefault();

        this.setState({
            message: '',
            messageShow: false
        });

        createUsers(this.state.title,this.state.description,this.state.email).then(data =>{

            switch (data.data) {
                case 'approve':
                    this.props.history.push({
                        pathname: '/view-job'
                    });
                    break;
                case 'spam':
                    this.setState({
                        message: "Your job post is successful but because it is your first post, please wait for board moderator's  approve",
                        messageShow: true
                    });
                    break;
                default:
                    break;
            }


        })
    };

    render() {

        return (
            <div className='row'>
                <div className='col-md-6 mx-auto m-3'>
                    <h4>Job Post!</h4>
                    <form noValidate style={this.state.from} className='m-3'>
                        {this.state.messageShow ?
                        <div className="form-group row alert alert-success" role="alert">
                            {this.state.message}
                        </div> :""}
                        <div className={this.state.titleError ? 'form-group row error' : 'form-group row'} >
                            <input className='input' type='text' name='title' autoComplete='off' value={this.state.title} onChange={this.handleChange} placeholder='Title'/>
                            {this.state.titleError ? <div className="error-message">Title is a required field.</div> : ''}
                        </div>
                        <div className={this.state.descriptionError ? 'form-group row error' : 'form-group row'}>
                            <textarea rows="10" className='input' autoComplete='off' name='description' onChange={this.handleChange} value={this.state.description}  placeholder='Description '>Description</textarea>
                            {this.state.descriptionError ? <div className="error-message">Description is a required field.</div> : ''}
                        </div>
                        <div className={this.state.emailError ? 'form-group row error' : 'form-group row'}>
                            <input className='input' type='text' autoComplete='off' name='email' value={this.state.email} onChange={this.handleChange}  placeholder='Email'/>
                            {this.state.emailError ? <div className="error-message">Email is a required field.</div> : ''}
                        </div>
                        <div className='form-group row'>
                            <button className='btn-login' disabled={!this.validate()} type='submit' onClick={this.submitForm} >Posts</button>
                        </div>
                    </form>

                </div>
            </div>
        )
    }
}

export default withRouter(Home);