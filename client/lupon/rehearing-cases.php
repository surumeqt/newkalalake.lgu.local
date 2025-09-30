<?php $cases = (new backend\controllers\casecontroller())->getRehearingCases(); ?>
<div class="rehearing-cases-container">
    <h1>Rehearing Cases</h1>
       <div class="search-filter-section">
        <input type="text" id="search-bar" placeholder="Search by case number, complainant, or respondent...">
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
                <?php if (empty($cases)): ?>
                    <tr><td colspan="6" style="text-align: center; color: red;">No cases found.</td></tr>
                <?php else: ?>
                    <?php foreach ($cases as $case): ?>
                        <tr>
                            <td><?= htmlspecialchars($case['case_number']) ?></td>
                            <td><?= htmlspecialchars($case['case_title']) ?></td>
                            <td><?= htmlspecialchars($case['complainant_name']) ?></td>
                            <td><?= htmlspecialchars($case['respondent_name']) ?></td>
                            <td><?= htmlspecialchars($case['hearing_status']) ?></td>
                            <td>
                                <?php if (!empty($case['case_id'])): ?>
                                    <a id="update-btn" onclick="showSummaryModal('<?= htmlspecialchars($case['case_id']) ?>')" >Update</a>
                                <?php else: ?>
                                    <span>No Case Id</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>