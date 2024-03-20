$(document).ready(
    function(){
        //Validate password
        $.validator.addMethod("passwordStrength", function(value, element){
            return this.optional(element) || /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
        }, "Password must contain at least 1 uppercase letter, 1 lowercase letter and 1 number, and at least 8 characters");

        //Validate form register
        $("#formRegister").validate({
            rules: {
                fullname: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 11
                },
                password: {
                    required: true,
                    passwordStrength: true
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                }

            },
            messages: {
                fullname: {
                    required: "Fullname is required",
                    minlength: "At least 3 characters"
                },
                email: {
                    required: "Email is required",
                    email: "Invalid email"
                },
                phone: {
                    required: "Phone number required",
                    digits: "Phone numbers must contain only numeric characters",
                    minlength: "At least 10 numeric characters",
                    maxlength: "Maximum 11 numeric characters"
                },
                password: {
                    required: "Password required",
                    passwordStrength: "Password must contain at least 1 uppercase letter, 1 lowercase letter and 1 number, and at least 8 characters"
                },
                password_confirm: {
                    required: "Re-password required",
                    equalTo: "The re-password does not match"
                }
            },
            errorPlacement:function(error, element){
                error.appendTo(element.parent().find(".error"));
            }
        });

        //Validate form reset
        $("#formReset").validate({
            rules: {
                password: {
                    required: true,
                    passwordStrength: true
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                }

            },
            messages: {
                password: {
                    required: "Password required",
                    passwordStrength: "Password must contain at least 1 uppercase letter, 1 lowercase letter and 1 number, and at least 8 characters"
                },
                password_confirm: {
                    required: "Re-password required",
                    equalTo: "The re-password does not match"
                }
            },
            errorPlacement:function(error, element){
                error.appendTo(element.parent().find(".error"));
            }
        });

        //Validate form edit user
        $("#formEditUser").validate({
            rules: {
                fullname: {
                    minlength: 3
                },
                email: {
                    email: true
                },
                phone: {
                    digits: true,
                    minlength: 10,
                    maxlength: 11
                }
                // current_password: {
                //     required: true
                // }
            },
            messages: {
                fullname: {
                    minlength: "At least 3 characters"
                },
                email: {
                    email: "Invalid email"
                },
                phone: {
                    digits: "Phone numbers must contain only numeric characters",
                    minlength: "At least 10 numeric characters",
                    maxlength: "Maximum 11 numeric characters"
                }
                // current_password: {
                //     required: "Current password required"
                // }
            },
            errorPlacement:function(error, element){
                error.appendTo(element.parent().find(".error"));
            }
        });

        //Validate form create job and company
        $("#formCreateJob").validate({
            rules: {
                "title-job": {
                    required: true,
                    minlength: 3
                },
                tags: {
                    required: true
                },
                salary: {
                    required: true,
                    digits: true
                },
                "title-company": {
                    required: true
                },
                "address": {
                    required: true
                },
                "phone": {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 11
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                "title-job": {
                    required: "Title job is required",
                    minlength: "At least 3 characters"
                },
                tags: {
                    required: "Tags is required"
                },
                salary: {
                    required: "Salary is required",
                    digits: "Salary must contain only numeric characters"
                },
                "title-company": {
                    required: "Title company is required"
                },
                "address": {
                    required: "Address company is required"
                },
                "phone": {
                    required: "Phone number required",
                    digits: "Phone numbers must contain only numeric characters",
                    minlength: "At least 10 numeric characters",
                    maxlength: "Maximum 11 numeric characters"
                },
                email: {
                    required: "Email is required",
                    email: "Invalid email"
                }
            },
            errorPlacement:function(error, element){
                error.appendTo(element.parent().find(".error"));
            }
        });

        // ajax form create job and company 
        $(".btn-save-submit").click(function(e){
            e.preventDefault();
            
            // check validate form
            if (!$("#formCreateJob").valid()) {
                return;
            }
            var formData = $(this).closest('form').serialize();
        
            $.ajax({
                url: 'ajax/handerSaveData.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ formData: formData, status: "add" }), 
                success: function(data){
                    if(data.status == 'success'){
                        alert('Save data success');
                        window.location.href = `details.php?id=${data.id}`;
                    } else {
                        alert('Save data fail');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            });
        });

        // ajax form update job and company 
        $(".btn-edit-submit").click(function(e){
            e.preventDefault();
            
            var formData = $(this).closest('form').serialize();

            var idListing = $(this).closest('[data-id-listing]').data('id-listing');
            var idCompany = $(this).closest('[data-id-company]').data('id-company');

        
            $.ajax({
                url: 'ajax/handerSaveData.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ formData: formData, status: "update", idListing: idListing, idCompany: idCompany}), 
                success: function(data){
                    if(data.status == 'success'){
                        alert('Update data success');
                        window.location.href = `details.php?id=${data.id}`;
                    } else {
                        alert('Update data fail');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            });
        });

    }
);