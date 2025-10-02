<div class="database-container">
  <div class="database-header">
    <h2>Database Record</h2>
    <div class="search-container">
      <div class="search-wrapper">
        <i class="fa fa-search search-icon"></i>
        <input type="text" placeholder="🔍Search by docket, name..." class="search-bar">
      </div>
      
      <select class="status-filter">
        <option value="all">All Cases</option>
        <option value="new">New</option>
        <option value="pending">Pending</option>
        <option value="rehearing">For Rehearing</option>
        <option value="mediation">For Mediation</option>
        <option value="settlement">For Settlement</option>
        <option value="settled">Settled</option>
        <option value="escalated">Escalated to Court</option>
        <option value="dismissed">Dismissed</option>
      </select>

      <button class="search-btn">
        <i class="fa fa-filter"></i> Search
      </button>
    </div>
  </div>

  <table class="records-table">
    <thead>
      <tr>
        <th><i class="fa fa-hashtag"></i> Docket No.</th>
        <th><i class="fa fa-file-alt"></i> Case Title</th>
        <th><i class="fa fa-user"></i> Complainant</th>
        <th><i class="fa fa-user-shield"></i> Respondent</th>
        <th><i class="fa fa-gavel"></i> Hearing Type</th>
        <th><i class="fa fa-align-left"></i> Summary</th>
        <th><i class="fa fa-info-circle"></i> Status</th>
        <th><i class="fa fa-clock"></i> Last Update</th>
        <th><i class="fa fa-cogs"></i> Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2025-001</td>
        <td>Noise Complaint</td>
        <td>Juan Dela Cruz</td>
        <td>Pedro Santos</td>
        <td>Mediation</td>
        <td>Excessive noise at night</td>
        <td><span class="status pending"><i class="fas fa-hourglass-half"></i> Pending</span></td>
        <td>2025-09-01</td>
        <td><button class="action-btn"><i class="fas fa-eye"></i></button></td>
      </tr>
      <tr>
        <td>2025-002</td>
        <td>Property Dispute</td>
        <td>Ana Reyes</td>
        <td>Carlos Dizon</td>
        <td>Arbitration</td>
        <td>Boundary conflict</td>
        <td><span class="status settled"><i class="fas fa-check-circle"></i> Settled</span></td>
        <td>2025-09-15</td>
        <td><button class="action-btn"><i class="fas fa-eye"></i></button></td>
      </tr>
      <tr>
        <td>2025-003</td>
        <td>Physical Altercation</td>
        <td>Maria Lopez</td>
        <td>Jose Cruz</td>
        <td>Hearing</td>
        <td>Barangay fight incident</td>
        <td><span class="status dismissed"><i class="fas fa-times-circle"></i> Dismissed</span></td>
        <td>2025-09-20</td>
        <td><button class="action-btn"><i class="fas fa-eye"></i></button></td>
      </tr>
      <tr>
        <td colspan="9" class="no-records">No records found</td>
      </tr>
    </tbody>
  </table>
</div>