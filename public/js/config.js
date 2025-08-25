export const CONFIG = {
  host: "localhost",
  project: "clinic",
  protocol: "http",
  get url() {
    return `${this.protocol}://${this.host}/${this.project}`;
  }
};