/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        app.receivedEvent('deviceready');
    },
    // Update DOM on a Received Event
    receivedEvent: function(id) {
        app.requestPayment(599);
    },
    requestPayment: function(amount) {
        var container = document.getElementById('paymentContainer');
        var button = document.getElementById('paymentButton');
        if (!container || !button) return;

        container.innerHTML = 'Please wait while we are preparing the payment...';
        button.style.display = 'none';

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost:8001/server.php?amount=' + amount + '&' + ((new Date()).getTime()));
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
                container.innerHTML = 'Press here to pay ' + amount.toFixed(2) + 'GBP';
                button.style.display = '';
                RealexHpp.setHppUrl('https://hpp.test.realexpayments.com/pay');
                RealexHpp.init('paymentButton', 'http://localhost:8000/success', JSON.parse(xhr.responseText));
            }
            else {
                container.innerHTML = 'An error occurred: ' + xhr.responseText;
            }
        };
        xhr.send();
    }
};

app.initialize();