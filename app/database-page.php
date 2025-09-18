<div class="database-container" id="database-page-container">
    <!-- Search and Filter Section -->
    <div class="filter-controls-container">
        <form onsubmit="return false;">
            <div class="filter-group">
                <label for="search-input" class="filter-label">Search:</label>
                <input
                    type="text"
                    id="search-input"
                    name="SearchByDcn"
                    class="filter-input"
                    placeholder="Search by docket, name, etc."
                    onkeyup="liveSearch()"
                >
            </div>
            <div class="filter-buttons">
                <div class="filter-group">
                    <label for="hearing-status-filter" class="filter-label">Hearing Status:</label>
                    <select id="hearing-status-filter" name="Hearing_status" class="filter-select" onchange="liveSearch()">
                        <option value="All_Status">All Statuses</option>
                        <option value="Settled">Settled</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Withdrawn">Withdrawn</option>
                        <option value="CFA">CFA</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Database Records Table -->
    <div class="records-table-wrapper">
        <table class="database-records-table">
            <thead>
                <tr>
                    <th>Docket No.</th>
                    <th>Case Title</th>
                    <th>Complainant</th>
                    <th>Respondent</th>
                    <th>Hearing Type</th>
                    <th>Summary</th>
                    <th>Status</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="records-body">
                <?php
                require_once '../backend/models/get.records.model.php';
                $model = new GetRecordsModel();
                $records = array_slice($model->getSummaryHistory(), 0, 10);
                ?>

                <?php if (!$records): ?>
                    <tr><td colspan="9" style="text-align: center;">No records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Docket_Case_Number']) ?></td>
                            <td><?= htmlspecialchars($row['Case_Title']) ?></td>
                            <td><?= htmlspecialchars($row['Complainant_Name']) ?></td>
                            <td><?= htmlspecialchars($row['Respondent_Name']) ?></td>
                            <td><?= htmlspecialchars($row['Hearing_Type']) ?></td>
                            <td>
                                <a href="../backend/get.summary.record.php?id=<?= $row['ID'] ?>" target="_blank">
                                    View Summary
                                </a>
                            </td>
                            <td class="status-<?= strtolower(str_replace(' ', '-', $row['Hearing_Status'])) ?>">
                                <?= htmlspecialchars($row['Hearing_Status']) ?>
                            </td>
                            <td><?= htmlspecialchars(date('Y-m-d', strtotime($row['Created_At']))) ?></td>
                            <td>
                                <button
                                    class="table-action-btn view-btn"
                                    data-docket="<?= htmlspecialchars($row['Docket_Case_Number']) ?>">
                                    View
                                </button>
                                <button
                                    class="table-action-btn delete-btn"
                                    data-docket="<?= htmlspecialchars($row['Docket_Case_Number']) ?>">
                                    delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
