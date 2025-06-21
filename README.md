<a id="readme-top"></a> 

<h1><center>Janus frontend</center></h1>

<div align="center">
  <a href="https://github.com/janus-bastion">
    <img src="https://github.com/janus-bastion/janus-frontend/blob/main/janus-website/janus-logo.png" alt="Janus Bastion Logo" width="160" height="160" />
  </a>

  <p><em>The frontend stack of the Janus project serving the web interface, handling database communication, and configuring the Nginx and PHP-FPM environment.
</em></p>

  <table align="center">
    <tr>
      <th>Author</th>
      <th>Author</th>
      <th>Author</th>
      <th>Author</th>
    </tr>
    <tr>
      <td align="center">
        <a href="https://github.com/nathanmartel21">
          <img src="https://github.com/nathanmartel21.png?size=115" width="115" alt="@nathanmartel21" /><br />
          <sub>@nathanmartel21</sub>
        </a>
        <br /><br />
        <a href="https://github.com/sponsors/nathanmartel21">
          <img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=white" alt="Sponsor nathanmartel21" />
        </a>
      </td>
      <td align="center">
        <a href="https://github.com/xeylou">
          <img src="https://github.com/xeylou.png?size=115" width="115" alt="@xeylou" /><br />
          <sub>@xeylou</sub>
        </a>
        <br /><br />
        <a href="https://github.com/sponsors/xeylou">
          <img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=white" alt="Sponsor xeylou" />
        </a>
      </td>
      <td align="center">
        <a href="https://github.com/Djegger">
          <img src="https://github.com/Djegger.png?size=115" width="115" alt="@Djegger" /><br />
          <sub>@Djegger</sub>
        </a>
        <br /><br />
        <a href="https://github.com/sponsors/Djegger">
          <img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=white" alt="Sponsor Djegger" />
        </a>
      </td>
      <td align="center">
        <a href="https://github.com/Warsgo">
          <img src="https://github.com/Warsgo.png?size=115" width="115" alt="@Warsgo" /><br />
          <sub>@Warsgo</sub>
        </a>
        <br /><br />
        <a href="https://github.com/sponsors/Warsgo">
          <img src="https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=white" alt="Sponsor Warsgo" />
        </a>
      </td>
    </tr>
  </table>
</div>

---

## Contents

- [`janus-conf-nginx/`](./janus-conf-nginx/): Nginx configuration for PHP-FPM integration.
- [`janus-db-connect/`](./janus-db-connect/): Database connection layer using mysqli.
- [`janus-website/`](./janus-website/): Main website files using HTML5, CSS3, PHP, and Chart.js.


## Features

- Structured modular frontend for the Janus ecosystem.
- PHP-FPM support for dynamic server-side rendering.
- Nginx configuration ready for production and development.
- mysqli-based secure DB communication.
- Built-in Chart.js integration for rich data visualization.

## Requirements

- [![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/fr/docs/Web/HTML)

- [![CSS3](https://img.shields.io/badge/CSS3-1572B6.svg?style=for-the-badge&logo=CSS3&logoColor=white)](https://developer.mozilla.org/fr/docs/Web/CSS)

- [![PHP-FPM](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)

- [![Nginx](https://img.shields.io/badge/Nginx-009639?style=for-the-badge&logo=nginx&logoColor=white)](https://nginx.org)

- [![MySQLI](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://www.php.net/manual/fr/book.mysqli.php)  

- [![Chart JS](https://img.shields.io/badge/Chart%20js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white)](https://www.chartjs.org/)  

## API

This frontend also exposes several API endpoints to retrieve data directly from the backend:

- `/api/users/count` — Returns the total number of users.
- `/api/remote_connections/count` — Returns the total number of remote connections.
- `/api/user/{username}` — Returns detailed information about a specific user by username.

### Authentication

All API endpoints require **HTTP Basic Authentication** with a valid username and password.

- Only users with **admin privileges** (`is_admin` set to true in the database) are authorized to access the APIs.
- If authentication fails, or if the user is not an admin, the API will respond with a `403 Forbidden` status.

### Example usage with `curl` :

```bash
curl -k -u admin_username:admin_password https://your-domain-or-ip/api/users/count
```

Replace `admin_username` and `admin_password` with the credentials of a valid admin user.

## Notes

- This frontend is designed to be lightweight and easily deployable inside containerized environments or directly on a server.

## License

This project is licensed under the GNU General Public License v3.0 [GPL-3.0](https://github.com/janus-bastion/.github/blob/main/LICENSE).  
See the `LICENSE` file for more details.
