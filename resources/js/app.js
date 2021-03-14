require('./bootstrap');

import axios from 'axios';
import {DataSet, Timeline} from 'vis-timeline/standalone';
import moment from 'moment';
import Swal from 'sweetalert2';

let container = document.getElementById('visualization');

/**
 * Method gets all consultations.
 */
axios({
    method: 'get',
    url: 'api/consultations'
})
    .then(function (response) {
        if (!response.data.data) {
            Swal.fire('Oops...', 'Response data is undefined', 'error');
        }

        renderTimeLine(response.data.data);
    })
    .catch(function (error) {
        Swal.fire(
            'Oops...',
            (error.message !== '') ? error.message : 'Something went wrong!',
            'error'
        );

        console.log(error);
    });


/**
 * Method renders the timeline table.
 *
 * @param data
 */
function renderTimeLine(data) {
    let items = new DataSet(data);

    let options = {
        type: 'background',
        editable: {
            add: true
        },
        minHeight: 300,
        zoomMin: 8.64e+6,
        zoomMax: 2.628e+9,
        onAdd: function (item, callback) {
            axios({
                method: 'post',
                url: 'api/consultations',
                data: {
                    date: moment.utc(item.start).format()
                }
            })
                .then(function (response) {
                    if (response.data.data) {
                        Swal.fire(
                            'Successful booking!',
                            'We are expecting you on ' + moment(response.data.data.start).format('MMMM Do YYYY, h:mm:ss a'),
                            'success'
                        );

                        callback(response.data.data);
                    } else {
                        Swal.fire('Oops...', 'Response data is undefined', 'error');

                        callback(null);
                    }
                })
                .catch(function (error) {
                    let title = 'Oops...';
                    let message = '';
                    let icon = 'error';

                    if (error.response) {
                        let errorData = error.response.data;

                        if (errorData.errors.global[0] !== '') {
                            title = 'Oh no...';
                            message = errorData.errors.global[0];
                            icon = 'info';
                        } else {
                            message = 'Something went wrong!';
                        }
                    } else {
                        message = 'Something went wrong!';
                    }

                    Swal.fire(title, message, icon);

                    callback(null);
                });
        }
    };

    let timeline = new Timeline(container, items, options);
}
