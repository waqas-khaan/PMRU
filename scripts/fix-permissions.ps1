# Make bootstrap/cache and storage writable so any developer can edit/run without permission errors.
# Run from repo root in PowerShell: .\scripts\fix-permissions.ps1
$ErrorActionPreference = "Stop"
$root = Split-Path -Parent (Split-Path -Parent $MyInvocation.MyCommand.Path)
Set-Location $root

$dirs = @(
    "bootstrap\cache",
    "storage\framework\cache",
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\logs"
)
foreach ($d in $dirs) {
    if (!(Test-Path $d)) { New-Item -ItemType Directory -Force -Path $d | Out-Null }
    icacls $d /grant "Everyone:(OI)(CI)F" /T 2>$null
}
Write-Host "Done: bootstrap/cache and storage are writable for all."
