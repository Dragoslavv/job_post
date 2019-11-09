import React, { Component } from 'react';
import './App.css';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Navigation from './scenes/components/Navigation';
import Home from './scenes/containers/Home';
import View from './scenes/containers/View';
import ErrorNotFound from "./scenes/containers/ErrorNotFound.js";


class App extends Component {
  render() {
    return (
      <div className="App">

          <Router>

              <div>
                  <Navigation />

                  <Switch>
                      <Route exact path="/view-job">
                          <View />
                      </Route>
                      <Route exact path="/">
                          <Home />
                      </Route>

                      /* 404 page */
                      <Route path="*" component={ErrorNotFound} />
                  </Switch>
              </div>

          </Router>
      </div>
    );
  }
}

export default App;
