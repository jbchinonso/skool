
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header h1 {
            font-size: 28px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .content {
            padding: 30px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .tab {
            padding: 12px 24px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
        }

        .tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab:hover {
            color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .form-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        input[type="text"],
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

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .class-card {
            background: white;
            border: 2px solid #f0f0f0;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
        }

        .class-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .class-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .class-name {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .class-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #e3f2fd;
            color: #1976d2;
        }

        .class-info {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        .info-label {
            color: #666;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .class-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 13px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
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

        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #667eea;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .classes-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Manage Classes</h1>
            <a href="view_all_students.html" class="btn btn-primary">View Students</a>
        </div>

        <div class="content">
            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" onclick="switchTab('add')">Add New Class</button>
                <button class="tab" onclick="switchTab('view')">View All Classes</button>
            </div>

            <!-- Add Class Tab -->
            <div id="addTab" class="tab-content active">
                <div class="form-card">
                    <h2 style="margin-bottom: 20px; color: #333;">Create New Class</h2>
                    
                    <div class="message" id="addMessage"></div>

                    <form id="addClassForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="className" class="required">Class Name</label>
                                <input type="text" id="className" name="className" placeholder="e.g., JSS 1A" required>
                            </div>

                            <div class="form-group">
                                <label for="classLevel" class="required">Class Level</label>
                                <select id="classLevel" name="classLevel" required>
                                    <option value="">Select Level</option>
                                    <option value="JSS1">JSS 1</option>
                                    <option value="JSS2">JSS 2</option>
                                    <option value="JSS3">JSS 3</option>
                                    <option value="SSS1">SSS 1</option>
                                    <option value="SSS2">SSS 2</option>
                                    <option value="SSS3">SSS 3</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="classTeacher">Class Teacher</label>
                                <input type="text" id="classTeacher" name="classTeacher" placeholder="Teacher's name">
                            </div>

                            <div class="form-group">
                                <label for="capacity">Class Capacity</label>
                                <input type="number" id="capacity" name="capacity" placeholder="Maximum students" min="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="classDescription">Description</label>
                            <textarea id="classDescription" name="classDescription" placeholder="Additional information about the class"></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Create Class</button>
                    </form>
                </div>
            </div>

            <!-- View Classes Tab -->
            <div id="viewTab" class="tab-content">
                <div id="loadingState" class="loading">Loading classes...</div>
                
                <div id="classesContainer" style="display: none;">
                    <div class="classes-grid" id="classesGrid"></div>
                </div>

                <div id="emptyState" class="empty-state" style="display: none;">
                    <p>No classes found</p>
                    <button class="btn-submit" onclick="switchTab('add')">Create First Class</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allClasses = [];

        // Load classes on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadClasses();

            // Add class form submission
            document.getElementById('addClassForm').addEventListener('submit', function(e) {
                e.preventDefault();
                addNewClass();
            });
        });

        function switchTab(tab) {
            // Update tab buttons
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            if (tab === 'add') {
                document.querySelectorAll('.tab')[0].classList.add('active');
                document.getElementById('addTab').classList.add('active');
            } else {
                document.querySelectorAll('.tab')[1].classList.add('active');
                document.getElementById('viewTab').classList.add('active');
                loadClasses();
            }
        }

        function addNewClass() {
            const form = document.getElementById('addClassForm');
            const message = document.getElementById('addMessage');
            const formData = new FormData(form);

            // Hide previous messages
            message.style.display = 'none';

            // Send to server
            fetch('<?php echo get_template_directory_uri().'/modules/classes/add_class.php';?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    message.className = 'message success';
                    message.textContent = data.message || 'Class created successfully!';
                    message.style.display = 'block';
                    form.reset();

                    // Reload classes
                    setTimeout(() => {
                        switchTab('view');
                    }, 1500);
                } else {
                    message.className = 'message error';
                    message.textContent = data.message || 'Failed to create class';
                    message.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                message.className = 'message error';
                message.textContent = 'Network error: ' + error.message;
                message.style.display = 'block';
            });
        }

        function loadClasses() {
            document.getElementById('loadingState').style.display = 'block';
            document.getElementById('classesContainer').style.display = 'none';
            document.getElementById('emptyState').style.display = 'none';

            fetch('<?php echo get_template_directory_uri().'/modules/classes/get_classes.php';?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingState').style.display = 'none';

                    if (data.success && data.classes.length > 0) {
                        allClasses = data.classes;
                        displayClasses(allClasses);
                        document.getElementById('classesContainer').style.display = 'block';
                    } else {
                        document.getElementById('emptyState').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('loadingState').innerHTML = 'Error loading classes';
                });
        }

        function displayClasses(classes) {
            const grid = document.getElementById('classesGrid');
            grid.innerHTML = '';

            classes.forEach(classData => {
                const card = document.createElement('div');
                card.className = 'class-card';
                card.innerHTML = `
                    <div class="class-header">
                        <div class="class-name">${classData.class_name}</div>
                        <span class="class-badge">${classData.class_level}</span>
                    </div>
                    <div class="class-info">
                        <div class="info-row">
                            <span class="info-label">Class Teacher:</span>
                            <span class="info-value">${classData.class_teacher || 'Not assigned'}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Students:</span>
                            <span class="info-value">${classData.student_count || 0} / ${classData.capacity || 'Unlimited'}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Created:</span>
                            <span class="info-value">${formatDate(classData.created_date)}</span>
                        </div>
                    </div>
                    ${classData.description ? `<p style="font-size: 13px; color: #666; margin-top: 10px;">${classData.description}</p>` : ''}
                    <div class="class-actions">
                        <button class="btn-small btn-edit" onclick="editClass(${classData.id})">Edit</button>
                        <button class="btn-small btn-delete" onclick="deleteClass(${classData.id}, '${classData.class_name}')">Delete</button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function editClass(classId) {
            // You can create an edit modal or redirect to edit page
            alert('Edit functionality - Class ID: ' + classId + '\nYou can create an edit modal or separate page for this.');
        }

        function deleteClass(classId, className) {
            if (!confirm(`Are you sure you want to delete "${className}"?\n\nThis action cannot be undone.`)) {
                return;
            }

            fetch('<?php echo get_template_directory_uri().'/modules/classes/delete_class.php';?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ class_id: classId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Class deleted successfully');
                    loadClasses();
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
