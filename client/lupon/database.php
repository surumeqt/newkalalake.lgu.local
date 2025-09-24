<div class="database-container">
    <h1>Database</h1>
    <p>This is the database page where you can manage and view all case records.</p>
    
    <div class="search-filter-section">
        <input type="text" id="search-bar" placeholder="Search by case number, complainant, or respondent...">
        <select id="case-status-filter">
            <option value="all">All Statuses</option>
            <option value="new">New</option>
            <option value="pending">Pending</option>
            <option value="rehearing">Rehearing</option>
            <option value="settled">Settled</option>
            <option value="endorsed">Endorsed</option>
        </select>
        <button id="search-button">Search</button>
    </div>

    <div class="case-table-container">
        <table>
            <thead>
                <tr>
                    <th>Case No.</th>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Date Filed</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2025-001</td>
                    <td>John Doe</td>
                    <td>Jane Smith</td>
                    <td>2025-09-20</td>
                    <td><span class="status pending">Pending</span></td>
                    <td><button class="action-btn view-btn">View</button></td>
                </tr>
                <tr>
                    <td>2025-002</td>
                    <td>The People</td>
                    <td>Alex Corpuz</td>
                    <td>2025-09-21</td>
                    <td><span class="status new">New</span></td>
                    <td><button class="action-btn view-btn">View</button></td>
                </tr>
                <tr>
                    <td>2025-003</td>
                    <td>Maria Garcia</td>
                    <td>Jose Cruz</td>
                    <td>2025-09-18</td>
                    <td><span class="status rehearing">Rehearing</span></td>
                    <td><button class="action-btn view-btn">View</button></td>
                </tr>
                <tr>
                    <td>2025-003</td>
                    <td>Maria Garcia</td>
                    <td>Jose Cruz</td>
                    <td>2025-09-18</td>
                    <td><span class="status rehearing">Rehearing</span></td>
                    <td><button class="action-btn view-btn">View</button></td>
                </tr>
                <tr>
                    <td>2025-003</td>
                    <td>Maria Garcia</td>
                    <td>Jose Cruz</td>
                    <td>2025-09-18</td>
                    <td><span class="status rehearing">Rehearing</span></td>
                    <td><button class="action-btn view-btn">View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>