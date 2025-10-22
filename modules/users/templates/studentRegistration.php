
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,rgb(242, 244, 244) 0%, #F0FBFC 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #06BBCC 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-container {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .row.full {
            grid-template-columns: 1fr;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #06BBCC;
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #06BBCC 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 20px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .success-message {
            display: none;
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            display: none;
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 600px) {
            .row {
                grid-template-columns: 1fr;
            }

            .form-container {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Registration</h1>
            <p>Secondary School Enrollment Form</p>
        </div>

        <div class="form-container">
            <div class="success-message" id="successMsg">Registration submitted successfully!</div>
            <div class="error-message" id="errorMsg">Please fill all required fields correctly.</div>

            <form id="registrationForm" method="POST" action="../studentRegister.php">
                <!-- Personal Information Section -->
                <div class="form-section-title">Personal Information</div>

                <div class="row">
                    <div class="form-group">
                        <label for="firstName" class="required">First Name</label>
                        <input type="text" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="required">Last Name</label>
                        <input type="text" id="lastName" name="lastName" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="gender" class="required">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="required">Date of Birth</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="required">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section-title">Contact Information</div>

                <div class="row">
                    <div class="form-group">
                        <label for="phone" class="required">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+234..." required>
                    </div>
                    <div class="form-group">
                        <label for="emergencyPhone">Emergency Contact Number</label>
                        <input type="tel" id="emergencyPhone" name="emergencyPhone" placeholder="+234...">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="required">Residential Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section-title">Academic Information</div>

                <div class="row">
                    <div class="form-group">
                        <label for="class" class="required">Class/Form</label>
                        <select id="class" name="class" required>
                            <option value="">Select Class</option>
                            <option value="JSS1">JSS 1</option>
                            <option value="JSS2">JSS 2</option>
                            <option value="JSS3">JSS 3</option>
                            <option value="SSS1">SSS 1</option>
                            <option value="SSS2">SSS 2</option>
                            <option value="SSS3">SSS 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jamb" class="required">JAMB Registration Number (if applicable)</label>
                        <input type="text" id="jamb" name="jamb">
                    </div>
                </div>

                <!-- Parent/Guardian Information Section -->
                <div class="form-section-title">Parent/Guardian Information</div>

                <div class="form-group">
                    <label for="parentName" class="required">Parent/Guardian Name</label>
                    <input type="text" id="parentName" name="parentName" required>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="parentPhone" class="required">Parent/Guardian Phone</label>
                        <input type="tel" id="parentPhone" name="parentPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="parentEmail">Parent/Guardian Email</label>
                        <input type="email" id="parentEmail" name="parentEmail">
                    </div>
                </div>

                <div class="form-group">
                    <label for="parentOccupation">Parent/Guardian Occupation</label>
                    <input type="text" id="parentOccupation" name="parentOccupation">
                </div>

                <!-- Submit Button -->
                <button type="submit">Complete Registration</button>
            </form>
        </div>
    </div>

    <script>
        
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const successMsg = document.getElementById('successMsg');
            const errorMsg = document.getElementById('errorMsg');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Hide messages
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting...';

            
            // Create FormData from form
            const formData = new FormData(form);

            console.log(formData);
            // Send data to PHP file using AJAX
            fetch('<?php echo get_template_directory_uri().'/modules/users/studentRegister.php'; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successMsg.textContent = data.message;
                    successMsg.style.display = 'block';
                    form.reset();
                    
                    // Reset button after 3 seconds
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Complete Registration';
                        successMsg.style.display = 'none';
                    }, 3000);
                } else {
                    errorMsg.textContent = data.message || 'An error occurred. Please try again.';
                    errorMsg.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Complete Registration';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMsg.textContent = 'Network error: ' + error.message;
                errorMsg.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Complete Registration';
            });
        });
    </script>
    </script>
</body>
</html>