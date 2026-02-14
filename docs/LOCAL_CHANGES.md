# Keeping Local Changes After Push/Merge to Main

## Why do my local changes seem to disappear?

1. **`.env` is not in Git**  
   Your `.env` file (APP_URL, database credentials, etc.) is in `.gitignore`, so it is **never pushed or merged**. That’s intentional for security. After a merge or a fresh clone you only have code; you need to restore config.

2. **Uncommitted work**  
   If you have uncommitted changes and you run `git pull`, `git merge`, or `git reset --hard origin/main`, you can lose those changes. Always commit or stash before pulling or resetting.

## What we added to fix this

### 1. Restore `.env` after merge (optional Git hook)

A **post-merge** hook can create `.env` from `.env.example` when it’s missing (e.g. after `git pull` or merge).

**One-time setup** (run in the project root):

```bash
git config core.hooksPath .githooks
chmod +x .githooks/post-merge
```

After that, whenever you run `git pull` (which does a merge), if `.env` is missing it will be created from `.env.example`. You still need to set `APP_KEY`, `APP_URL`, and DB credentials.

### 2. Manual restore script

If you don’t use the hook, or you’re on a new clone:

```bash
sh scripts/ensure-env.sh
```

This creates `.env` from `.env.example` only when `.env` doesn’t exist. Then run `php artisan key:generate` and edit `.env` with your values.

### 3. Safe workflow so you don’t lose work

- **Commit before pull/merge**  
  `git status` → commit or stash changes → then `git pull origin main`.

- **Don’t use `git reset --hard`** unless you intend to throw away local changes.

- **Keep a backup of `.env`** (e.g. `.env.backup` or a secure note). It’s not in the repo, so only you have it.

- **After merge on another machine**  
  Pull as usual, then run `sh scripts/ensure-env.sh` (or use the hook above) and reconfigure `.env` for that environment.

## Summary

| Situation                         | What to do                                                                 |
|----------------------------------|----------------------------------------------------------------------------|
| `.env` missing after clone/merge | Run `sh scripts/ensure-env.sh` or use the post-merge hook (see above).     |
| Don’t want to lose uncommitted   | Commit or `git stash` before `git pull` or `git merge`; avoid `--hard`.    |
| Same project, different machine  | Pull, then run `ensure-env.sh` and copy/rebuild your `.env` for that box.  |
