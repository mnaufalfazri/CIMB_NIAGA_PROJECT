const fs = require('fs');
const path = require('path');

const files = [
    'c:/CIMB PROJECT/Transfer/resources/js/pages/transfer/receipt.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/transfer/history.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/transfer/confirm.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/payment/receipt.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/payment/history.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/payment/create.tsx',
    'c:/CIMB PROJECT/Transfer/resources/js/pages/payment/confirm.tsx',
];

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Extract breadcrumbs prop
    const breadcrumbsMatch = content.match(/<AppSidebarLayout breadcrumbs={(\[.*?\])}>/s);
    if (!breadcrumbsMatch) {
        console.log(`No match in ${file}`);
        continue;
    }
    
    const breadcrumbs = breadcrumbsMatch[1];
    
    // Replace opening tag
    content = content.replace(/<AppSidebarLayout breadcrumbs={\[.*?\]}>/s, '<>');
    
    // Replace closing tag
    // We only want to replace the LAST closing tag or the one that matches our opening tag.
    // The easiest is just replacing the last occurrence of </AppSidebarLayout>
    const lastIndex = content.lastIndexOf('</AppSidebarLayout>');
    if (lastIndex !== -1) {
        content = content.substring(0, lastIndex) + '</>' + content.substring(lastIndex + '</AppSidebarLayout>'.length);
    }
    
    // Find component name
    const componentNameMatch = content.match(/export default function ([a-zA-Z0-9_]+)/);
    if (!componentNameMatch) {
        console.log(`No component name in ${file}`);
        continue;
    }
    const componentName = componentNameMatch[1];
    
    // Remove existing .layout if present
    content = content.replace(new RegExp(`^${componentName}\\.layout.*$`, 'm'), '');
    
    // Add new layout definition
    content += `\n\n${componentName}.layout = (page: React.ReactNode) => (\n    <AppSidebarLayout breadcrumbs={${breadcrumbs}}>\n        {page}\n    </AppSidebarLayout>\n);\n`;
    
    fs.writeFileSync(file, content, 'utf8');
    console.log(`Updated ${file}`);
}
