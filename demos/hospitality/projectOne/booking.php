<?php include 'header.php'; ?>

    <div style="padding-top: 150px; min-height: 80vh;">
        <div class="container">
            <div class="center-text reveal" style="margin-bottom: 50px;">
                <span class="subtitle">Reservations</span>
                <h1 class="heading-lg">Secure Your <span class="gold italic">Sanctuary</span></h1>
            </div>

            <div class="reveal" style="background: var(--bg-card); padding: 50px; border: 1px solid var(--border-color); max-width: 800px; margin: 0 auto;">
                <form action="#" method="GET" style="display: grid; gap: 30px;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <label style="display: block; color: var(--gold); font-size: 0.7rem; text-transform: uppercase; margin-bottom: 10px;">Arrival</label>
                            <input type="date" required>
                        </div>
                        <div>
                            <label style="display: block; color: var(--gold); font-size: 0.7rem; text-transform: uppercase; margin-bottom: 10px;">Departure</label>
                            <input type="date" required>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; color: var(--gold); font-size: 0.7rem; text-transform: uppercase; margin-bottom: 10px;">Guests</label>
                        <select>
                            <option>2 Adults</option>
                            <option>4 Adults</option>
                            <option>Family Suite</option>
                        </select>
                    </div>

                    <button type="submit" class="submit-btn">Check Availability</button>

                </form>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>