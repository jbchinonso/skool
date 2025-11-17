<?php
/**
 * Template Name: Check Result Page
 *
 * The template for displaying Result checking Page.
 *
 * @category Template
 *
 * @package skool
 *
 * @author Johnbosco
 *
 * @license skool Use Only <https://www.skool.com/>
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();

wp_enqueue_style('skool-result', get_template_directory_uri() . '/assets/css/result.css', [], _S_VERSION);

?>

    <div class="container">
        <div class="header">
            <h1>Check Your Result</h1>
            <p>Enter your details to view your academic result</p>
        </div>

        <div class="form-container">
            <div class="info-box">
                <strong>Note:</strong> You need a valid scratch card PIN to view your result. Contact the school office if you don't have one.
            </div>

            <div class="error-message" id="errorMsg"></div>
            <div class="success-message" id="successMsg"></div>

            <form id="resultForm">
                <div class="form-group">
                    <label for="regNumber" class="required">Registration Number</label>
                    <input type="text" id="regNumber" name="regNumber" placeholder="e.g., SS/2024/001" required>
                    <div class="help-text">Enter your student registration number</div>
                </div>

                <div class="form-group">
                    <label for="class" class="required">Class</label>
                    <select id="class" name="class" required>
                        <option value="">Select Your Class</option>
                        <option value="JSS1">JSS 1</option>
                        <option value="JSS2">JSS 2</option>
                        <option value="JSS3">JSS 3</option>
                        <option value="SSS1">SSS 1</option>
                        <option value="SSS2">SSS 2</option>
                        <option value="SSS3">SSS 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="term" class="required">Term</label>
                    <select id="term" name="term" required>
                        <option value="">Select Term</option>
                        <option value="First Term">First Term</option>
                        <option value="Second Term">Second Term</option>
                        <option value="Third Term">Third Term</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="session" class="required">Academic Session</label>
                    <select id="session" name="session" required>
                        <option value="">Select Session</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2023/2024">2023/2024</option>
                        <option value="2022/2023">2022/2023</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="scratchPin" class="required">Scratch Card PIN</label>
                    <input type="text" id="scratchPin" name="scratchPin" class="pin-input" placeholder="XXXX-XXXX-XXXX" maxlength="14" required>
                    <div class="help-text">Enter the 12-digit PIN from your scratch card</div>
                </div>

                <button type="submit" id="submitBtn">View Result</button>
            </form>

            <div class="back-link">
                <a href="index.html">← Back to Home</a>
            </div>
        </div>
    </div>

    <script>
        // Format PIN input with dashes
        document.getElementById('scratchPin').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
            let formatted = '';
            
            for (let i = 0; i < value.length && i < 12; i++) {
                if (i > 0 && i % 4 === 0) {
                    formatted += '-';
                }
                formatted += value[i];
            }
            
            e.target.value = formatted;
        });

        // Handle form submission
        document.getElementById('resultForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const errorMsg = document.getElementById('errorMsg');
            const successMsg = document.getElementById('successMsg');
            const submitBtn = document.getElementById('submitBtn');
            
            // Hide messages
            errorMsg.style.display = 'none';
            successMsg.style.display = 'none';
            
            // Get form values
            const regNumber = document.getElementById('regNumber').value.trim();
            const studentClass = document.getElementById('class').value;
            const term = document.getElementById('term').value;
            const session = document.getElementById('session').value;
            const scratchPin = document.getElementById('scratchPin').value.replace(/-/g, '');
            
            // Validate
            if (!regNumber || !studentClass || !term || !session || !scratchPin) {
                errorMsg.textContent = 'Please fill all required fields';
                errorMsg.style.display = 'block';
                return;
            }
            
            if (scratchPin.length !== 12) {
                errorMsg.textContent = 'Invalid PIN format. PIN must be 12 characters';
                errorMsg.style.display = 'block';
                return;
            }
            
            // Disable button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Verifying...';
            
            // Create FormData
            const formData = new FormData();
            formData.append('regNumber', regNumber);
            formData.append('class', studentClass);
            formData.append('term', term);
            formData.append('session', session);
            formData.append('scratchPin', scratchPin);
            
            // Send to server
            fetch('../verify_result.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successMsg.textContent = 'Verification successful! Redirecting...';
                    successMsg.style.display = 'block';
                    
                    // Redirect to result page with student ID
                    setTimeout(() => {
                        window.location.href = 'result_sheet.html?id=' + data.student_id + 
                                               '&term=' + encodeURIComponent(term) + 
                                               '&session=' + encodeURIComponent(session);
                    }, 1500);
                } else {
                    errorMsg.textContent = data.message || 'Verification failed. Please check your details.';
                    errorMsg.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'View Result';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMsg.textContent = 'Network error: ' + error.message;
                errorMsg.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = 'View Result';
            });
        });
    </script>

<?php
get_footer();
?>