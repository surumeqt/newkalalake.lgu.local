<div class="database-container">
    <h1>Database</h1>

    <div class="search-filter-section">
        <input type="text" id="search-bar" placeholder="Search by case number, complainant, or respondent...">
        <select id="case-status-filter">
            <option value="all">All Statuses</option>
            <option value="settled">Settled</option>
            <option value="dismissed">Dismissed</option>
            <option value="withdrawn">Withdrawn</option>
            <option value="cfa">For CFA</option>
            <option value="rehearing">Rehearing</option>
        </select>
        <button id="search-button">Search</button>
    </div>

    <div class="case-table-container">
        <table>
            <thead>
                <tr>
                    <th>Case No.</th>
                    <th>Case Title</th>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Hearing Type</th>
                    <th>Hearing Status</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NK-01-01-25</td>
                    <td>Pambabastos/Death threat</td>
                    <td>MARC ALEXIS GAPUL</td>
                    <td>KEVIN DULAY</td>
                    <td>1st Hearing</td>
                    <td>Settled</td>
                    <td>01-01-2025</td>
                    <td>
                        <a href="">View</a>
                        <a href="">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>