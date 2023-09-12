import { render } from '@react-email/render'
import * as React from 'react';
import * as path from "path";

const [node, script, view, json] = process.argv;

import(`./${path.relative(__dirname, view)}`).then((module) => {
    const Email = module.default
    const data = json ? JSON.parse(json) : []
    const html = render(<Email {...data} />, {
        pretty: true,
    });

    const text = render(<Email {...data} />, {
        plainText: true,
    });

    console.log(JSON.stringify({html, text}));
})
