<?php
session_start();

require_once '../janus-include/header.php';

?>

<div class="main-content">
    <div style="background-color: #2f3640; padding: 30px; border-radius: 10px; max-width: 500px; width: 100%; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
        <h2 style="margin-bottom: 20px; text-align: center; color: #fff;">New Remote Connection</h2>
        <form action="../janus-mdlw/janus-create-connect.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="connection_name" placeholder="Connection name" required style="padding: 10px; border-radius: 6px; border: none;">

            <select name="protocol" required style="padding: 10px; border-radius: 6px; border: none; color: #555;">
                <option value="">-- Select a protocol --</option>
                <option value="ssh">SSH</option>
                <option value="vnc">VNC</option>
                <option value="rdp">RDP</option>
            </select>

            <input type="text" name="ip_address" placeholder="IP Address" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="number" name="port" placeholder="Port (empty for default)" style="padding: 10px; border-radius: 6px; border: none;">
            <input type="text" name="username" placeholder="Username" required style="padding: 10px; border-radius: 6px; border: none;">
            <input type="password" name="password" placeholder="Password" style="padding: 10px; border-radius: 6px; border: none;">
            <textarea name="notes" placeholder="Additional notes" style="padding: 10px; border-radius: 6px; border: none; min-height: 80px;"></textarea>

            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 10px; background-color: #5684AE; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; flex: 1;">
                    Create Connection
                </button>
                <a href="javascript:history.back()" style="padding: 10px; background-color: #555; color: white; font-weight: bold; border: none; border-radius: 6px; cursor: pointer; text-align: center; text-decoration: none; flex: 1;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../janus-include/footer.php'; ?>
