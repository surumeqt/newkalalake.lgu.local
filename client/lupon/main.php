<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/fonts.css">
    <link rel="stylesheet" href="../../public/css/root.css">
    <link rel="stylesheet" href="../../public/css/main.css">
    <link rel="stylesheet" href="../../public/css/luponpages.css">
    <title>Lupon System</title>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Lupon System</h2>
            <button id="menu-toggle" onclick="toggleSidebar()">
                <img src="../../public/assets/icons/menu-burger.png" alt="menu">
            </button>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="/lupon/dashboard">
                        <img src="../../public/assets/icons/dashboard-panel.png" alt="dashboard">
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/lupon/database">
                        <img src="../../public/assets/icons/database.png" alt="database">
                        <span>Database</span>
                    </a>
                </li>
                <li>
                    <a href="/lupon/new-cases">
                        <img src="../../public/assets/icons/legal-case.png" alt="case">
                        <span>New Cases</span>
                    </a>
                </li>
                <li>
                    <a href="/lupon/pending-cases">
                        <img src="../../public/assets/icons/pending.png" alt="pending">
                        <span>Pending Cases</span>
                    </a>
                </li>
                <li>
                    <a href="/lupon/rehearing-cases">
                        <img src="../../public/assets/icons/calendar-clock.png" alt="rehearing">
                        <span>Rehearing Cases</span>
                    </a>
                </li>
                <li>
                    <a href="/lupon/upload-cases">
                        <img src="../../public/assets/icons/document-circle-arrow-up.png" alt="home">
                        <span>Upload Old Cases</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button onclick="showLogoutModal()">
                <img src="../../public/assets/icons/user-logout.png" alt="logout">
                <span>Logout</span>
            </button>
        </div>
    </aside>
    
    <main class="main-content">
        <?php if (isset($pageToLoad)) { require $pageToLoad; } ?>
    </main>

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout?</p>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="showLogoutModal()">Cancel</button>
                <form action="/logout" method="POST" style="display:inline;" onsubmit="event.preventDefault()">
                    <button class="confirm-btn" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <form action="/update-status" method="POST" onsubmit="event.preventDefault()">
                <h2>Update Status</h2>
                <p>Are you sure you want to change the status for this case?</p>
                <p>it will be change to : 
                    <span>
                        <select name="hearing_status">
                            <option value="Rehearing">Rehearing</option>
                            <option value="Settled">Settled</option>
                            <option value="Dismissed">Dismissed</option>
                            <option value="Withdrawn">Withdrawn</option>
                            <option value="CFA">CFA</option>
                        </select>
                    </span>
                </p>
                <div class="modal-actions">
                    <button class="cancel-btn" onclick="showUpdateModal()">Cancel</button>
                    <input hidden type="number" id="case-number-update" name="case_id">
                    <button class="confirm-btn" type="submit">Yes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="addSummaryModal" class="modal">
        <div class="modal-content">
            <form action="/add-summary" method="POST" onsubmit="event.preventDefault()">
                <h2>Add Case Summary/Resolution</h2>

                <div class="form-group">
                    <label for="summary-text">Summary/Resolution Details</label>
                    <textarea 
                        id="summary-text" 
                        name="summary_text" 
                        rows="5" 
                        placeholder="Enter the final summary or resolution details for this case."
                        required
                    ></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="summary-date">Date of Resolution</label>
                        <input type="date" id="summary-date" name="summary_date" required>
                    </div>

                    <div class="form-group">
                        <label for="summary-time">Time</label>
                        <input type="time" id="summary-time" name="summary_time" required>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="cancel-btn" onclick="showSummaryModal()">Cancel</button>
                    <input hidden type="number" id="case-number-summary" name="case_id">
                    <button class="confirm-btn" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Delete Case</h2>
            <p>Are you sure you want to DELETE this case?</p>
            <div class="modal-actions">
                <button class="cancel-btn" onclick="showDeleteModal()">Cancel</button>
                <form action="/delete-case" method="POST" style="display:inline;">
                    <input hidden type="number" id="case-number-delete" name="case_id">
                    <button class="confirm-btn" type="submit">Yes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../public/js/functions.js"></script>
</body>
</html>