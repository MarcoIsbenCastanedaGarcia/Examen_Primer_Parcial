document.addEventListener('DOMContentLoaded', () => {
    initializeTheme();
    initializeMenus();
    initializeAlerts();
    initializeConfirmations();
    initializeLogout();
    initializePasswordToggle();
    initializeRejectForms();
    initializeCalendar();
});

function initializeTheme() {
    const root = document.documentElement;

    const buttons = document.querySelectorAll(
        '[data-theme-toggle]'
    );

    const storedTheme =
        localStorage.getItem('app-theme');

    const preferredDark =
        window.matchMedia &&
        window.matchMedia(
            '(prefers-color-scheme: dark)'
        ).matches;

    const theme =
        storedTheme ||
        (preferredDark ? 'dark' : 'light');

    root.setAttribute(
        'data-theme',
        theme
    );

    buttons.forEach((button) => {
        button.addEventListener(
            'click',
            () => {
                const current =
                    root.getAttribute(
                        'data-theme'
                    );

                const next =
                    current === 'dark'
                        ? 'light'
                        : 'dark';

                root.setAttribute(
                    'data-theme',
                    next
                );

                localStorage.setItem(
                    'app-theme',
                    next
                );
            }
        );
    });
}

function initializeMenus() {
    const buttons =
        document.querySelectorAll(
            '[data-menu-toggle]'
        );

    buttons.forEach((button) => {
        button.addEventListener(
            'click',
            () => {
                const header =
                    button.closest(
                        'header'
                    );

                if (!header) {
                    return;
                }

                const menu =
                    header.querySelector(
                        '[data-menu]'
                    );

                if (!menu) {
                    return;
                }

                menu.classList.toggle(
                    'menu-open'
                );
            }
        );
    });
}

function initializeAlerts() {
    const buttons =
        document.querySelectorAll(
            '[data-alert-close]'
        );

    buttons.forEach((button) => {
        button.addEventListener(
            'click',
            () => {
                const alert =
                    button.closest(
                        '.alert'
                    );

                if (alert) {
                    alert.remove();
                }
            }
        );
    });
}

function initializeConfirmations() {
    const forms =
        document.querySelectorAll(
            'form[data-confirm]'
        );

    forms.forEach((form) => {
        form.addEventListener(
            'submit',
            (event) => {
                const message =
                    form.dataset.confirm ||
                    '¿Seguro que deseas continuar?';

                const accepted =
                    window.confirm(
                        message
                    );

                if (!accepted) {
                    event.preventDefault();
                }
            }
        );
    });
}

function initializeLogout() {
    const forms =
        document.querySelectorAll(
            '[data-logout-form]'
        );

    forms.forEach((form) => {
        form.addEventListener(
            'submit',
            (event) => {
                const accepted =
                    window.confirm(
                        '¿Seguro que quieres cerrar sesión?'
                    );

                if (!accepted) {
                    event.preventDefault();
                }
            }
        );
    });
}

function initializePasswordToggle() {
    const buttons =
        document.querySelectorAll(
            '[data-password-toggle]'
        );

    buttons.forEach((button) => {
        button.addEventListener(
            'click',
            () => {
                const wrapper =
                    button.closest(
                        '.password-wrapper'
                    );

                if (!wrapper) {
                    return;
                }

                const input =
                    wrapper.querySelector(
                        '[data-password-input]'
                    );

                if (!input) {
                    return;
                }

                input.type =
                    input.type === 'password'
                        ? 'text'
                        : 'password';
            }
        );
    });
}

function initializeRejectForms() {
    const buttons =
        document.querySelectorAll(
            '[data-reject-open]'
        );

    buttons.forEach((button) => {
        button.addEventListener(
            'click',
            () => {
                const id =
                    button.dataset.rejectOpen;

                const box =
                    document.querySelector(
                        `[data-reject-box="${id}"]`
                    );

                if (!box) {
                    return;
                }

                box.hidden =
                    !box.hidden;
            }
        );
    });
}

function initializeCalendar() {
    const grid =
        document.querySelector(
            '[data-calendar-grid]'
        );

    const title =
        document.querySelector(
            '[data-calendar-title]'
        );

    const previous =
        document.querySelector(
            '[data-calendar-prev]'
        );

    const next =
        document.querySelector(
            '[data-calendar-next]'
        );

    const dataElement =
        document.getElementById(
            'loan-calendar-data'
        );

    if (
        !grid ||
        !title ||
        !previous ||
        !next
    ) {
        return;
    }

    let loans = [];

    if (dataElement) {
        try {
            loans =
                JSON.parse(
                    dataElement.dataset.loans ||
                    '[]'
                );
        } catch {
            loans = [];
        }
    }

    let currentDate =
        new Date();

    currentDate =
        new Date(
            currentDate.getFullYear(),
            currentDate.getMonth(),
            1
        );

    const monthNames = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];

    const render = () => {
        grid.innerHTML = '';

        const year =
            currentDate.getFullYear();

        const month =
            currentDate.getMonth();

        title.textContent =
            `${monthNames[month]} ${year}`;

        const firstDay =
            new Date(
                year,
                month,
                1
            );

        let startWeekday =
            firstDay.getDay();

        startWeekday =
            startWeekday === 0
                ? 6
                : startWeekday - 1;

        const daysInMonth =
            new Date(
                year,
                month + 1,
                0
            ).getDate();

        const today =
            new Date();

        for (
            let i = 0;
            i < startWeekday;
            i++
        ) {
            const empty =
                document.createElement(
                    'div'
                );

            empty.className =
                'calendar-day empty';

            grid.appendChild(
                empty
            );
        }

        for (
            let day = 1;
            day <= daysInMonth;
            day++
        ) {
            const date =
                new Date(
                    year,
                    month,
                    day
                );

            const cell =
                document.createElement(
                    'div'
                );

            cell.className =
                'calendar-day';

            if (
                date.getFullYear() ===
                    today.getFullYear() &&
                date.getMonth() ===
                    today.getMonth() &&
                date.getDate() ===
                    today.getDate()
            ) {
                cell.classList.add(
                    'calendar-today'
                );
            }

            const number =
                document.createElement(
                    'span'
                );

            number.className =
                'calendar-number';

            number.textContent =
                String(day);

            cell.appendChild(
                number
            );

            const dailyLoans =
                loans.filter(
                    (loan) => {
                        const start =
                            new Date(
                                loan.start
                            );

                        return (
                            start.getFullYear() ===
                                year &&
                            start.getMonth() ===
                                month &&
                            start.getDate() ===
                                day
                        );
                    }
                );

            dailyLoans.forEach(
                (loan) => {
                    const event =
                        document.createElement(
                            'span'
                        );

                    event.className =
                        'calendar-event';

                    const equipment =
                        Array.isArray(
                            loan.equipment
                        )
                            ? loan.equipment.join(
                                ', '
                            )
                            : '';

                    event.textContent =
                        equipment ||
                        `Préstamo #${loan.id}`;

                    event.title =
                        `${loan.user}: ${equipment}`;

                    cell.appendChild(
                        event
                    );
                }
            );

            grid.appendChild(
                cell
            );
        }

        const totalCells =
            grid.children.length;

        const remaining =
            totalCells % 7 === 0
                ? 0
                : 7 - (
                    totalCells % 7
                );

        for (
            let i = 0;
            i < remaining;
            i++
        ) {
            const empty =
                document.createElement(
                    'div'
                );

            empty.className =
                'calendar-day empty';

            grid.appendChild(
                empty
            );
        }
    };

    previous.addEventListener(
        'click',
        () => {
            currentDate =
                new Date(
                    currentDate.getFullYear(),
                    currentDate.getMonth() - 1,
                    1
                );

            render();
        }
    );

    next.addEventListener(
        'click',
        () => {
            currentDate =
                new Date(
                    currentDate.getFullYear(),
                    currentDate.getMonth() + 1,
                    1
                );

            render();
        }
    );

    render();
}