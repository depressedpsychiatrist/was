import MainLayout from "./layouts/MainLayout.vue";
import AuthLayout from "./layouts/AuthLayout.vue";

export const routes = [{
        path: "/auth",
        component: AuthLayout,
        children: [{
                path: "/login",
                name: "login",
                component: () => import("./pages/auth/Login.vue"),
            },
            {
                path: "/signup",
                name: "signup",
                component: () => import("./pages/auth/Signup.vue"),
            },
        ]
    },
    {
        path: "/",
        component: MainLayout,
        meta: {
            requiresAuth: true,
        },
        children: [{
                path: "",
                meta: {
                    employeeAuth: true,
                },
                children: [{
                    path: "employee-form",
                    name: "employeeForm",
                    component: () => import("./pages/EmployeeForm.vue"),
                }, ]

            },
            {
                path: "",
                meta: {
                    hrAuth: true,
                },
                children: [{
                    path: "employee-list",
                    name: "employeeList",
                    component: () => import("./pages/EmployeeList.vue"),
                }]
            }

        ],
    },
];
