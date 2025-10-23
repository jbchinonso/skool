<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Students - School Portal</title>
    <style>

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>All Students</h1>
            <div class="header-actions">
                <a href="index.html" class="btn btn-primary">+ Register New Student</a>
            </div>
        </div>

        <div class="content">
            <!-- Statistics -->
            <div class="stats">
                <div class="stat-card">
                    <h3 id="totalStudents">0</h3>
                    <p>Total Students</p>
                </div>
                <div class="stat-card">
                    <h3 id="jssStudents">0</h3>
                    <p>JSS Students</p>
                </div>
                <div class="stat-card">
                    <h3 id="sssStudents">0</h3>
                    <p>SSS Students</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search by name, email, or phone...">
                </div>
                <select id="classFilter" class="filter-select">
                    <option value="">All Classes</option>
                    <option value="JSS1">JSS 1</option>
                    <option value="JSS2">JSS 2</option>
                    <option value="JSS3">JSS 3</option>
                    <option value="SSS1">SSS 1</option>
                    <option value="SSS2">SSS 2</option>
                    <option value="SSS3">SSS 3</option>
                </select>
                <select id="genderFilter" class="filter-select">
                    <option value="">All Genders</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="loading">
                Loading students...
            </div>

            <!-- Students Table -->
            <div class="table-wrapper" id="tableWrapper" style="display: none;">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Parent/Guardian</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody">
                    </tbody>
                </table>
            </div>

            <!-- No Students State -->
            <div id="noStudents" class="no-students" style="display: none;">
                <p>No students found</p>
                <a href="index.html" class="btn btn-primary">Register First Student</a>
            </div>

            <!-- Pagination -->
            <div class="pagination" id="pagination" style="display: none;"></div>
        </div>
    </div>

    <script>
        let allStudents = [];
        let filteredStudents = [];
        let currentPage = 1;
        const studentsPerPage = 10;

        // Load students on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStudents();
            
            // Set up event listeners for filters
            document.getElementById('searchInput').addEventListener('input', filterStudents);
            document.getElementById('classFilter').addEventListener('change', filterStudents);
            document.getElementById('genderFilter').addEventListener('change', filterStudents);
        });

        function loadStudents() {
            fetch('<?php echo get_template_directory_uri().'/modules/users/get_students.php'; ?>')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        allStudents = data.students;
                        filteredStudents = allStudents;
                        updateStatistics();
                        displayStudents();
                        document.getElementById('loadingState').style.display = 'none';
                        
                        if (allStudents.length > 0) {
                            document.getElementById('tableWrapper').style.display = 'block';
                            document.getElementById('pagination').style.display = 'flex';
                        } else {
                            document.getElementById('noStudents').style.display = 'block';
                        }
                    } else {
                        document.getElementById('loadingState').innerHTML = 'Error loading students: ' + data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingState').innerHTML = 'Network error: ' + error.message;
                });
        }

        function updateStatistics() {
            const total = allStudents.length;
            const jss = allStudents.filter(s => s.class.startsWith('JSS')).length;
            const sss = allStudents.filter(s => s.class.startsWith('SSS')).length;
            
            document.getElementById('totalStudents').textContent = total;
            document.getElementById('jssStudents').textContent = jss;
            document.getElementById('sssStudents').textContent = sss;
        }

        function filterStudents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const classFilter = document.getElementById('classFilter').value;
            const genderFilter = document.getElementById('genderFilter').value;
            
            filteredStudents = allStudents.filter(student => {
                const matchesSearch = 
                    student.first_name.toLowerCase().includes(searchTerm) ||
                    student.last_name.toLowerCase().includes(searchTerm) ||
                    student.email.toLowerCase().includes(searchTerm) ||
                    student.phone.includes(searchTerm);
                
                const matchesClass = !classFilter || student.class === classFilter;
                const matchesGender = !genderFilter || student.gender === genderFilter;
                
                return matchesSearch && matchesClass && matchesGender;
            });
            
            currentPage = 1;
            displayStudents();
        }

        function displayStudents() {
            const tbody = document.getElementById('studentsTableBody');
            tbody.innerHTML = '';
            
            const startIndex = (currentPage - 1) * studentsPerPage;
            const endIndex = startIndex + studentsPerPage;
            const studentsToShow = filteredStudents.slice(startIndex, endIndex);
            
            studentsToShow.forEach(student => {
                const initials = (student.first_name.charAt(0) + student.last_name.charAt(0)).toUpperCase();
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div class="student-photo">${initials}</div>
                            <div>
                                <div style="font-weight: 600;">${student.first_name} ${student.last_name}</div>
                                <div style="font-size: 12px; color: #999;">ID: ${student.user_id}</div>
                            </div>
                        </div>
                    </td>
                    <td>${student.email}</td>
                    <td>${student.phone}</td>
                    <td><span class="class-badge">${student.class}</span></td>
                    <td>${student.gender}</td>
                    <td>
                        <div style="font-size: 13px;">${student.parent_name}</div>
                        <div style="font-size: 12px; color: #999;">${student.parent_phone}</div>
                    </td>
                    <td>
                        <a href="student_profile.html?id=${student.user_id}" class="action-btn">View Profile</a>
                    </td>
                `;
                tbody.appendChild(row);
            });
            
            displayPagination();
        }

        function displayPagination() {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            
            const totalPages = Math.ceil(filteredStudents.length / studentsPerPage);
            
            if (totalPages <= 1) {
                pagination.style.display = 'none';
                return;
            }
            
            pagination.style.display = 'flex';
            
            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.textContent = '← Previous';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayStudents();
                }
            };
            pagination.appendChild(prevBtn);
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const pageBtn = document.createElement('button');
                    pageBtn.textContent = i;
                    pageBtn.className = i === currentPage ? 'active' : '';
                    pageBtn.onclick = () => {
                        currentPage = i;
                        displayStudents();
                    };
                    pagination.appendChild(pageBtn);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    const dots = document.createElement('span');
                    dots.textContent = '...';
                    dots.style.padding = '8px';
                    pagination.appendChild(dots);
                }
            }
            
            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.textContent = 'Next →';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    displayStudents();
                }
            };
            pagination.appendChild(nextBtn);
        }
    </script>
</body>
</html>