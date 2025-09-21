<div class="case-entry-container">
    <form class="case-form">
        <div class="form-header-row">
            <h2>Case Entry Form</h2>
            <div class="input-flex">
                <input type="text" placeholder="Docket Case Number" id="docket-case-number" name="docket-case-number">
                <select id="nature-type" name="nature-type">
                    <option value="" disabled selected>Nature of Case</option>
                    <option value="criminal">Criminal Case</option>
                    <option value="civil">Civil Case</option>
                </select>
            </div>
        </div>
        <div class="form-columns-container">
            <div class="form-column" id="complainant-details">
                <h3>Complainant Details</h3>
                <label for="complainant-name">Name:</label>
                <input type="text" id="complainant-name" name="complainant-name">

                <label for="complainant-address">Address:</label>
                <input type="text" id="complainant-address" name="complainant-address">
            </div>
            <div class="form-column" id="respondent-details">
                <h3>Respondent Details</h3>
                <label for="respondent-name">Name:</label>
                <input type="text" id="respondent-name" name="respondent-name">

                <label for="respondent-address">Address:</label>
                <input type="text" id="respondent-address" name="respondent-address">
            </div>
            <div class="form-column" id="hearing-details">
                <h3>Hearing Details</h3>
                <label for="hearing-date">Date:</label>
                <input type="date" id="hearing-date" name="hearing-date">

                <label for="hearing-time">Time:</label>
                <input type="time" id="hearing-time" name="hearing-time">
            </div>
        </div>
        <div class="form-submit-row">
            <button type="submit" class="submit-button">Submit</button>
        </div>
    </form>
</div>