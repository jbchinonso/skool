<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - School Portal</title>
    <style>

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }


        .btn-secondary {
            background: white;
            color: #667eea;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .content {
            padding: 40px;
        }

        .loading {
            text-align: center;
            padding: 60px 20px;
            color: #667eea;
            font-size: 16px;
        }


        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .class-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            background: #e3f2fd;
            color: #1976d2;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-edit:hover {
            background: #764ba2;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Student Profile</h1>
            <a href="admin.php?page=view-all-students" class="btn btn-secondary">← Back to All Students</a>
        </div>

        <div class="content">
            <!-- Loading State -->
            <div id="loadingState" class="loading">
                Loading student profile...
            </div>

            <!-- Profile Content -->
            <div id="profileContent" style="display: none;">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-photo" id="profilePhoto"></div>
                    <div class="profile-info">
                        <h2 id="studentName"></h2>
                        <div class="profile-meta">
                            <span id="studentClass"></span>
                            <span>•</span>
                            <span id="studentGender"></span>
                            <span>•</span>
                            <span id="studentId"></span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="section">
                    <h3 class="section-title">Personal Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value" id="studentEmail"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value" id="studentPhone"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value" id="studentDOB"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Emergency Contact</div>
                            <div class="info-value" id="emergencyPhone"></div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">Residential Address</div>
                            <div class="info-value" id="studentAddress"></div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="section">
                    <h3 class="section-title">Academic Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Current Class</div>
                            <div class="info-value" id="currentClass"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">JAMB Registration</div>
                            <div class="info-value" id="jambReg"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Registration Date</div>
                            <div class="info-value" id="registrationDate"></div>
                        </div>
                    </div>
                </div>

                <!-- Parent/Guardian Information -->
                <div class="section">
                    <h3 class="section-title">Parent/Guardian Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Parent/Guardian Name</div>
                            <div class="info-value" id="parentName"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Parent/Guardian Phone</div>
                            <div class="info-value" id="parentPhone"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Parent/Guardian Email</div>
                            <div class="info-value" id="parentEmail"></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Parent/Guardian Occupation</div>
                            <div class="info-value" id="parentOccupation"></div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="actions">
                    <button class="btn btn-edit" onclick="editStudent()">Edit Profile</button>
                    <button class="btn btn-delete" onclick="deleteStudent()">Delete Student</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStudentId = null;

        // Load student profile on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            currentStudentId = urlParams.get('id');
            
            if (!currentStudentId) {
                document.getElementById('loadingState').innerHTML = 'No student ID provided';
                return;
            }
            
            loadStudentProfile(currentStudentId);
        });

        function loadStudentProfile(studentId) {
            fetch(`<?php echo get_template_directory_uri() . '/modules/users/get_student.php?id='?> ${studentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayStudentProfile(data.student);
                        document.getElementById('loadingState').style.display = 'none';
                        document.getElementById('profileContent').style.display = 'block';
                    } else {
                        document.getElementById('loadingState').innerHTML = 'Error: ' + data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingState').innerHTML = 'Network error: ' + error.message;
                });
        }

        function displayStudentProfile(student) {
            // Profile photo initials
            const initials = (student.first_name.charAt(0) + student.last_name.charAt(0)).toUpperCase();
            document.getElementById('profilePhoto').textContent = initials;
            
            // Profile header
            document.getElementById('studentName').textContent = student.first_name + ' ' + student.last_name;
            document.getElementById('studentClass').innerHTML = '<span class="class-badge">' + (student.class || 'N/A') + '</span>';
            document.getElementById('studentGender').textContent = student.gender || 'N/A';
            document.getElementById('studentId').textContent = 'ID: ' + student.user_id;
            
            // Personal information
            document.getElementById('studentEmail').textContent = student.email || 'N/A';
            document.getElementById('studentPhone').textContent = student.phone || 'N/A';
            document.getElementById('studentDOB').textContent = formatDate(student.date_of_birth) || 'N/A';
            document.getElementById('emergencyPhone').textContent = student.emergency_phone || 'N/A';
            document.getElementById('studentAddress').textContent = student.address || 'N/A';
            
            // Academic information
            document.getElementById('currentClass').innerHTML = '<span class="class-badge">' + (student.class || 'N/A') + '</span>';
            document.getElementById('jambReg').textContent = student.jamb_registration || 'N/A';
            document.getElementById('registrationDate').textContent = formatDate(student.registration_date) || formatDate(student.registered_date) || 'N/A';
            
            // Parent/Guardian information
            document.getElementById('parentName').textContent = student.parent_name || 'N/A';
            document.getElementById('parentPhone').textContent = student.parent_phone || 'N/A';
            document.getElementById('parentEmail').textContent = student.parent_email || 'N/A';
            document.getElementById('parentOccupation').textContent = student.parent_occupation || 'N/A';
        }

        function formatDate(dateString) {
            if (!dateString) return null;
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        function editStudent() {
            // Redirect to edit page (you'll need to create this)
            window.location.href = 'edit_student.html?id=' + currentStudentId;
        }

        function deleteStudent() {
            if (!confirm('Are you sure you want to delete this student? This action cannot be undone.')) {
                return;
            }
            
            fetch('../delete_student.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ student_id: currentStudentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Student deleted successfully');
                    window.location.href = 'view_all_students.html';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error: ' + error.message);
            });
        }
    </script>
</body>
</html>