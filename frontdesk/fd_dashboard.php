<div class="dashboard-container">
    <div class="dashboard-intro">
        <h1>Dashboard</h1>
        <p>Your central hub for managing Barangay New Kalalake services and information.</p>
    </div>

    <div class="dashboard-section metrics-section">
        <h2>
            <div class="icon-wrapper" style="margin-top: 10px;">
                <img src="images/icons/chart32.png" alt="Chart Icon">
            </div> Key Statistics
        </h2>
        <div class="metrics-grid-container">
            <div class="dashboard-grid-item grid-item-1">
                <div class="icon-wrapper">
                    <img src="images/icons/users48.png" alt="Total Residents Icon">
                </div>
                <h3 id="total-residents-metric">0</h3>
                <p>Total Residents</p>
                <small>As of <span id="current-date-total-residents">if you see this, hello</span></small>
            </div>

            <div class="dashboard-grid-item grid-item-2">
                <div class="icon-wrapper">
                    <img src="images/icons/user48.png" alt="Residents Registered Today Icon">
                </div>
                <h3 id="residents-registered-today-metric">0</h3>
                <p>Residents Registered (Today)</p>
                <small>As of <span id="current-date-registered-today">if you see this, hello</span></small>
            </div>

            <div class="dashboard-grid-item grid-item-3">
                <div class="icon-wrapper">
                    <img src="images/icons/filehistory48.png" alt="Total Certificates Issued Icon">
                </div>
                <h3 id="total-certificates-issued-metric">0</h3>
                <p>Total Certificates Issued</p>
                <small>Overall count</small>
            </div>

            <div class="dashboard-grid-item grid-item-4">
                <div class="icon-wrapper">
                    <img src="images/icons/file48.png" alt="Certificates Issued Today Icon">
                </div>
                <h3 id="certificates-issued-today-metric">0</h3>
                <p>Certificates Issued (Today)</p>
                <small>As of <span id="current-date-certificates-today">if you see this, hello</span></small>
            </div>
        </div>
    </div>

    <div class="dashboard-section charts-section">
        <h2>
            <div class="icon-wrapper" style="margin-top: 10px;">
                <img src="images/icons/bar-graph-32.png" alt="Bar Graph Icon">
            </div> Demographic Insights
        </h2>
        <div class="charts-grid-container">
            <div class="dashboard-grid-item chart-placeholder">
                <h4 class="chart-title">Gender Distribution</h4>
                <div class="chart-mockup bar-chart">
                    <div class="bar-set">
                        <div class="bar" id="gender-male-bar" style="height: 70%; background-color: var(--chart-male);" title="Male: 688">
                        </div>
                        <div class="bar" id="gender-female-bar" style="height: 55%; background-color: var(--chart-female);"
                            title="Female: 562"></div>
                    </div>
                    <div class="bar-labels">
                        <span>Male (<span id="gender-male-count">0</span>)</span>
                        <span>Female (<span id="gender-female-count">0</span>)</span>
                    </div>
                </div>
                <small class="chart-note">Breakdown of residents by gender.</small>
            </div>

            <div class="dashboard-grid-item chart-placeholder">
                <h4 class="chart-title">Age Group Distribution</h4>
                <div class="chart-mockup bar-chart">
                    <div class="bar-set" id="age-group-bars">
                        <div class="bar" id="age-0-17-bar" style="height: 40%;" title="0-17: 200"></div>
                        <div class="bar" id="age-18-35-bar" style="height: 90%;" title="18-35: 450"></div>
                        <div class="bar" id="age-36-60-bar" style="height: 70%;" title="36-60: 350"></div>
                        <div class="bar" id="age-60-plus-bar" style="height: 30%;" title="60+: 250"></div>
                    </div>
                    <div class="bar-labels" id="age-group-labels">
                        <span>0-17 (<span id="age-0-17-count">0</span>)</span>
                        <span>18-35 (<span id="age-18-35-count">0</span>)</span>
                        <span>36-60 (<span id="age-36-60-count">0</span>)</span>
                        <span>60+ (<span id="age-60-plus-count">0</span>)</span>
                    </div>
                </div>
                <small class="chart-note">Breakdown of residents by age categories.</small>
            </div>
        </div>
    </div>

    <div class="dashboard-section activity-section">
        <h2>
            <div class="icon-wrapper" style="margin-top: 10px;">
                <img src="images/icons/history32.png" alt="History Icon">
            </div>
            Recent Activities
        </h2>
        <div class="activity-feed-container">
            <div class="activity-feed">
                <ul id="recent-activities-list">
                    <li><strong>July 29, 2025:</strong> Resident "Maria Santos" updated profile.</li>
                    <li><strong>July 29, 2025:</strong> New resident "Jose Rizal" registered.</li>
                    <li><strong>July 28, 2025:</strong> New request for Barangay Clearance received.</li>
                    <li><strong>July 28, 2025:</strong> 3 Certificates of Indigency issued.</li>
                    <li><strong>July 27, 2025:</strong> New resident "Juan Dela Cruz" registered.</li>
                    <li><strong>July 27, 2025:</strong> Barangay event "Clean-up Drive" planned.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
