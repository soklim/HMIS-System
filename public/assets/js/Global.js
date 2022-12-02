var MSG = {
    Error: function (text) {
        Swal.fire({
            type: 'error',
            title: 'Oops...',
            html: text,
        })
    },
    Warning: function (text) {
        Swal.fire({
            type: 'warning',
            title: 'Oops...',
            html: text,
        })
    },
    Permission_Deny: function () {
        Swal.fire({
            type: 'error',
            title: 'Permission Denied...',
            html: "User have no permission!!!",
        })
    },
    Validation: function (text) {

        Swal.fire({
            title: 'Required',
            type: 'info',
            html: text,
            closeModal: false
        })

    },
    Success: function () {
        Swal.fire({
            position: 'top-center',
            type: 'success',
            title: 'Save Successful!',
            showConfirmButton: false,
            timer: 1200
        })
    },
    Loading: function () {
        Swal.fire({
            title: '<i>Loading</u>',
            type: 'info',
            html: 'Please wait data is loading...',
        })
    }
}
